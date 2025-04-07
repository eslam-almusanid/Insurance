<?php

namespace App\Integrations\Services\Najm;

use App\Integrations\Interfaces\NajmServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class NajmService implements NajmServiceInterface
{
    protected $baseUrl;
    protected $apiToken;
    protected $apiKey;
    protected $clientId;

    public function __construct()
    {
        $this->baseUrl = config('najm.api_base_url', 'https://api.najm.sa');
        $this->apiToken = config('najm.api_token');
        $this->apiKey = config('najm.api_key');
        $this->clientId = config('najm.client_id');
    }

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
            ],
        ];
    }

    protected function getHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->apiToken,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-API-Key' => $this->apiKey,
            'X-Client-ID' => $this->clientId,
            'Accept-Language' => 'en',
            'X-Request-ID' => Str::uuid()->toString(),
        ];
    }

    public function checkPolicyStatus(string $nationalId, string $vehicleSequenceNumber, string $policyNumber): array
    {
        $response = Http::withHeaders($this->getHeaders())
            ->post("{$this->baseUrl}/api/v1/policy/status", [
                'national_id' => $nationalId,
                'vehicle_sequence_number' => $vehicleSequenceNumber,
                'policy_number' => $policyNumber,
            ]);

        return $this->handleResponse($response);
    }

    public function submitClaim(array $claimData): array
    {
        $response = Http::withHeaders($this->getHeaders())
            ->post("{$this->baseUrl}/api/v1/claims", $claimData);

        return $this->handleResponse($response);
    }

    public function getInsuranceOffers(string $nationalId, string $vehicleSequenceNumber, bool $isCustomCar = false): array
    {
        $response = Http::withHeaders($this->getHeaders())
            ->get("{$this->baseUrl}/api/v1/insurance/offers", [
                'national_id' => $nationalId,
                'vehicle_sequence_number' => $vehicleSequenceNumber,
                'is_custom_car' => $isCustomCar,
            ]);

        return $this->handleResponse($response);
    }

    protected function handleResponse($response): array
    {
        if ($response->successful()) {
            return $response->json();
        }

        logger()->error("Najm API request failed: " . $response->body(), $response->status());
        throw new \Exception("Najm API request failed: " . $response->body(), $response->status());
    }
}