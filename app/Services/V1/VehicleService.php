<?php

namespace App\Services\V1;

use App\Repositories\Interfaces\VehicleRepositoryInterface;

class VehicleService
{
    protected $vehicleRepository;

    public function __construct(VehicleRepositoryInterface $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    public function getAllVehicles()
    {
        return $this->vehicleRepository->all();
    }

    public function getVehicle($id)
    {
        return $this->vehicleRepository->find($id);
    }

    public function createVehicle(array $data)
    {
        return $this->vehicleRepository->create($data);
    }

    public function updateVehicle($id, array $data)
    {
        return $this->vehicleRepository->update($id, $data);
    }

    public function deleteVehicle($id)
    {
        return $this->vehicleRepository->delete($id);
    }
}