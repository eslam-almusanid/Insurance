<?php

namespace App\Integrations\Najm;

use App\Integrations\Interfaces\NajmServiceInterface;
use Illuminate\Support\Str;

class NajmMockService implements NajmServiceInterface
{
    public function getVehicleInfo(string $nationalId, string $vehicleSequenceNumber): array
    {
        // Mock data لمعلومات السيارة فقط
        return [
            'status' => 'success',
            'message' => 'Vehicle information retrieved successfully',
            'data' => [
                'national_id' => $nationalId,
                'vehicle_sequence_number' => $vehicleSequenceNumber,
                'plate' => 'أ ب ج 123',
                'make' => 'Toyota',
                'model' => 'Camry',
                'year' => 2020,
                'color' => 'White',
                'type' => 'Sedan',
                'modification_status' => 'Standard',
                'vin' => 'JT2BF22K0X0123456', // رقم الشاسيه
                'registration_date' => '2020-06-01',
                'owner_name' => 'Mohammed Abdullah Al-Otaibi'
            ],
            'errors' => null,
            'timestamp' => now()->toIso8601String(),
            'request_id' => Str::uuid()->toString()
        ];
    }
    public function checkPolicyStatus(string $nationalId, string $vehicleSequenceNumber, string $policyNumber): array
    {
        // Mock data للتحقق من حالة البوليصة
        return [
            'status' => 'success',
            'message' => 'Policy status retrieved successfully',
            'data' => [
                'national_id' => $nationalId,
                'vehicle_sequence_number' => $vehicleSequenceNumber,
                'policy_number' => $policyNumber,
                'insurance_status' => 'active',
                'provider' => 'Tawuniya Insurance',
                'valid_from' => '2025-04-03',
                'valid_to' => '2026-04-02',
                'coverage_type' => 'Comprehensive',
                'no_claims_discount_eligible' => true
            ],
            'errors' => null,
            'timestamp' => now()->toIso8601String(),
            'request_id' => Str::uuid()->toString()
        ];
    }

    public function submitClaim(array $claimData): array
    {
        // Mock data لتقديم مطالبة
        return [
            'status' => 'success',
            'message' => 'Claim submitted successfully',
            'data' => [
                'claim_id' => 'CLM-' . date('Y') . '-' . str_pad(rand(1, 9999), 6, '0', STR_PAD_LEFT),
                'national_id' => $claimData['national_id'],
                'vehicle_sequence_number' => $claimData['vehicle_sequence_number'],
                'accident_date' => $claimData['accident_date'],
                'status' => 'pending_review',
                'submitted_at' => now()->toIso8601String()
            ],
            'errors' => null,
            'timestamp' => now()->toIso8601String(),
            'request_id' => Str::uuid()->toString()
        ];
    }

    public function getInsuranceOffers(string $nationalId, string $vehicleSequenceNumber, bool $isCustomCar = false): array
    {
        // Mock data لعروض التأمين
        $offers = [
            [
                'company' => 'Tawuniya Insurance',
                'custom_car_support' => true,
                'policy_type' => 'Comprehensive Plus',
                'premium' => 5000, // SAR
                'notes' => 'Requires vehicle inspection'
            ],
            [
                'company' => 'Medgulf Insurance',
                'custom_car_support' => true,
                'policy_type' => 'Comprehensive',
                'premium' => 4500, // SAR
                'notes' => 'Covers up to 50% of modification value'
            ]
        ];

        if (!$isCustomCar) {
            $offers[] = [
                'company' => 'Al Rajhi Takaful',
                'custom_car_support' => false,
                'policy_type' => 'Third Party Liability',
                'premium' => 1200, // SAR
                'notes' => 'Standard vehicles only'
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Insurance offers retrieved successfully',
            'data' => $offers,
            'errors' => null,
            'timestamp' => now()->toIso8601String(),
            'request_id' => Str::uuid()->toString()
        ];
    }
}