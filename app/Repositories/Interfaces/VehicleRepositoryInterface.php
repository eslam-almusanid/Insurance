<?php

namespace App\Repositories\Interfaces;

interface VehicleRepositoryInterface
{
    public function find($id);
    public function all();
    public function create(array $data);
    public function updateOrCreate(array $data);
    public function update($id, array $data);
    public function delete($id);
}
