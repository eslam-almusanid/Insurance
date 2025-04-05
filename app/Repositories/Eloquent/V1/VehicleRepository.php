<?php

namespace App\Repositories\Eloquent\V1;

use App\Models\Vehicle;
use App\Repositories\Interfaces\VehicleRepositoryInterface;

class VehicleRepository implements VehicleRepositoryInterface
{
    protected $model;

    public function __construct(Vehicle $model)
    {
        $this->model = $model;
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function updateOrCreate(array $data)
    {
        return $this->model->updateOrCreate(['sequence_number' => $data['sequence_number']], $data);
    }

    public function update($id, array $data)
    {
        $vehicle = $this->find($id);
        $vehicle->update($data);
        return $vehicle;
    }

    public function delete($id)
    {
        $vehicle = $this->find($id);
        return $vehicle->delete();
    }
}