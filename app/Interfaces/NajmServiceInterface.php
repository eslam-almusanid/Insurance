<?php

namespace App\Interfaces;

interface NajmServiceInterface
{
    public function checkPolicyStatus(string $nationalId, string $vehicleSequenceNumber, string $policyNumber): array;
    public function submitClaim(array $claimData): array;
    public function getInsuranceOffers(string $nationalId, string $vehicleSequenceNumber, bool $isCustomCar = false): array;
    public function getVehicleInfo(string $nationalId, string $vehicleSequenceNumber): array;
}