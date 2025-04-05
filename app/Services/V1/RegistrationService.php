<?php

namespace App\Services\V1;

use App\Enums\TokenTypesEnum;
use App\Interfaces\NajmServiceInterface;
use App\Interfaces\YakeenServiceInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Exception;

class RegistrationService
{
    protected VehicleRepositoryInterface $vehicleRepository;
    protected UserRepositoryInterface $userRepository;
    protected NajmServiceInterface $najmService;
    protected YakeenServiceInterface $yakeenService;

    public function __construct(
        VehicleRepositoryInterface $vehicleRepository,
        NajmServiceInterface $najmService,
        YakeenServiceInterface $yakeenService,
        UserRepositoryInterface $userRepository
    ) {
        $this->vehicleRepository = $vehicleRepository;
        $this->userRepository = $userRepository;
        $this->najmService = $najmService;
        $this->yakeenService = $yakeenService;
    }

    /**
     * Verify user identity using Yakeen service
     * 
     * @param string $nationalId
     * @return array
     * @throws Exception
     */
    public function verifyIdentity(string $nationalId): array
    {
        $identity = $this->yakeenService->verifyIdentity($nationalId);
        if ($identity['status'] !== 'success') {
            throw new Exception('Identity not found: ' . ($identity['message'] ?? 'Unknown error'));
        }
        return $identity['data'];
    }

    /**
     * Verify vehicle information using Najm service
     * 
     * @param string $nationalId
     * @param string $sequenceNumber
     * @return array
     * @throws Exception
     */
    public function verifyVehicle(string $nationalId, string $sequenceNumber): array
    {
        $vehicle = $this->najmService->getVehicleInfo(
            $nationalId,
            $sequenceNumber
        );

        if ($vehicle['status'] !== 'success') {
            throw new Exception('Vehicle not found: ' . ($vehicle['message'] ?? 'Unknown error'));
        }
        return $vehicle['data'];
    }

    /**
     * Create a new registration for a user and vehicle
     * 
     * @param array $data
     * @return array
     * @throws Exception
     */
    public function create(array $data): array
    {
        try {
            DB::beginTransaction();
            
            // 1. Verify the identity from yakeen
            $identity = $this->verifyIdentity($data['national_id']);

            // 2. Verify the vehicle from najm
            $vehicle = $this->verifyVehicle($data['national_id'], $data['sequence_number']);
            
            // 3. Create or update user
            $user = $this->updateOrCreateUser($identity, $data);
            
            // 4. Create or update vehicle
            $vehicleModel = $this->updateOrCreateVehicle($vehicle, $user, $data);

            DB::commit();
            return [
                'user' => $user,
                'vehicle' => $vehicleModel
            ];
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Vehicle registration failed: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Create or update user based on identity data
     * 
     * @param array $identity
     * @param array $data
     * @return Model
     */
    protected function updateOrCreateUser(array $identity, array $data): Model
    {
        return $this->userRepository->updateOrCreate(
            [
                'national_id' => $identity['national_id'],
                'name' => $identity['full_name_ar'],
                'email' => $identity['email'] ?? null,
                'password' => $identity['password'] ?? null,
                'phone' => $identity['phone_number'] ?? null,
                'address' => $identity['address'] ?? null,
                'role' => TokenTypesEnum::USER,
                'language' => $data['language'] ?? 'ar',
            ]
        );
    }

    /**
     * Create or update vehicle based on vehicle data
     * 
     * @param array $vehicle
     * @param Model $user
     * @param array $data
     * @return Model
     */
    protected function updateOrCreateVehicle(array $vehicle, Model $user, array $data): Model
    {
        $separatedPlate = $this->separatePlate($vehicle['plate']);
        
        return $this->vehicleRepository->updateOrCreate(
            [
                'sequence_number' => $vehicle['vehicle_sequence_number'],
                'plate_char_ar' => $separatedPlate['letters'],
                'plate_char_en' => $separatedPlate['letters'],
                'plate_number_ar' => $separatedPlate['numbers'],
                'plate_number_en' => $separatedPlate['numbers'],
                'make' => $vehicle['make'],
                'model' => $vehicle['model'],
                'year' => $vehicle['year'],
                'color' => $vehicle['color'],
                'type' => $vehicle['type'],
                'modification_status' => $vehicle['modification_status'],
                'vin' => $vehicle['vin'],
                'registration_date' => $vehicle['registration_date'],
                'owner_name' => $vehicle['owner_name'],

                'user_id' => $user->id,
                'month' => $data['month'] ?? null,
                'manufacture_year' => $data['manufacture_year'] ?? null,
                'parking_location' => $data['parking_location'] ?? '',
                'transmission_type' => $data['transmission_type'] ?? '',
                'expected_annual_mileage' => $data['expected_annual_mileage'] ?? '',
                'has_trailer' => $data['has_trailer'] ?? false,
                'used_for_racing' => $data['used_for_racing'] ?? false,
                'has_modifications' => $data['has_modifications'] ?? false,
                'load' => $data['load'] ?? 0,
                'price' => $data['price'] ?? null,
            ]
        );
    }

    /**
     * Separate plate numbers and characters
     * 
     * @param string $plate The full plate number (e.g. "أ ب ج 123")
     * @return array Array containing numbers and characters separately
     */
    public function separatePlate(string $plate): array
    {
        // Remove spaces and convert to array of characters
        $chars = array_filter(explode(' ', $plate));

        // Separate numbers and characters
        $numbers = [];
        $letters = [];

        foreach ($chars as $char) {
            if (is_numeric($char)) {
                $numbers[] = $char;
            } else {
                $letters[] = $char;
            }
        }

        return [
            'numbers' => implode('', $numbers),
            'letters' => implode(' ', $letters)
        ];
    }
}
