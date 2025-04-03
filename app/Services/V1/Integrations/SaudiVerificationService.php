<?php

namespace App\Services\V1\Integrations;

// use App\Services\Contracts\SaudiVerificationServiceInterface;
// implements SaudiVerificationServiceInterface

class SaudiVerificationService
{
    public function verifyYakeenId(string $nationalId): array
    {
        if (strlen($nationalId) === 10 && preg_match('/^[1-2][0-9]{9}$/', $nationalId)) {
            return [
                'status' => 'success',
                'message' => 'ID verification completed successfully',
                'data' => [
                    'national_id' => $nationalId,
                    'is_valid' => true,
                    'full_name_ar' => 'محمد عبدالله العتيبي',
                    'full_name_en' => 'Mohammed Abdullah Al-Otaibi',
                    'date_of_birth_hijri' => '1400-05-15',
                    'date_of_birth_gregorian' => '1980-03-22',
                    'gender' => 'male',
                    'nationality' => 'Saudi',
                    'id_issue_date' => '1435-08-10',
                    'id_expiry_date' => '1445-08-09',
                    'status_code' => '200'
                ],
                'errors' => null,
                'timestamp' => now()->toIso8601String()
            ];
        }

        return [
            'status' => 'error',
            'message' => 'Invalid National ID',
            'data' => null,
            'errors' => [
                'code' => 'INVALID_ID',
                'description' => 'The provided National ID does not exist in the system.'
            ],
            'timestamp' => now()->toIso8601String()
        ];
    }

    public function checkNajm(string $nationalId, string $vehicleSequenceNumber): array
    {
        if (strlen($vehicleSequenceNumber) === 12 && is_numeric($vehicleSequenceNumber)) {
            return [
                'status' => 'success',
                'message' => 'Najm verification completed successfully',
                'data' => [
                    'national_id' => $nationalId,
                    'vehicle_sequence_number' => $vehicleSequenceNumber,
                    'vehicle_plate' => 'أ ب ج 123',
                    'vehicle_make' => 'Toyota',
                    'vehicle_model' => 'Camry',
                    'vehicle_year' => 2020,
                    'insurance_status' => 'active',
                    'insurance_expiry_date' => '2025-12-31',
                    'accidents' => [
                        [
                            'accident_id' => 'ACC987654',
                            'date' => '2024-06-15',
                            'location' => 'Riyadh, King Fahd Road',
                            'fault_status' => 'at_fault',
                            'description' => 'Rear-end collision'
                        ]
                    ],
                    'total_accidents' => 1,
                    'status_code' => '200'
                ],
                'errors' => null,
                'timestamp' => now()->toIso8601String()
            ];
        }

        return [
            'status' => 'error',
            'message' => 'Vehicle not found',
            'data' => null,
            'errors' => [
                'code' => 'INVALID_VEHICLE',
                'description' => 'The provided vehicle sequence number is not registered.'
            ],
            'timestamp' => now()->toIso8601String()
        ];
    }
}