<?php

namespace App\Integrations\Yakeen;

use App\Integrations\Interfaces\YakeenServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class YakeenService implements YakeenServiceInterface
{
    protected $baseUrl;
    protected $apiToken;
    protected $apiKey;
    protected $clientId;

    public function __construct()
    {
        $this->baseUrl = config('yakeen.api_base_url', 'https://api.yakeen.sa');
        $this->apiToken = config('yakeen.api_token');
        $this->apiKey = config('yakeen.api_key');
        $this->clientId = config('yakeen.client_id');
    }

    /**
     * Get common headers for all API requests
     */
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

    /**
     * Verify identity using Yakeen API
     */
    public function verifyIdentity(string $nationalId): array
    {
        $response = Http::withHeaders($this->getHeaders())
            ->post("{$this->baseUrl}/api/v1/identity/verify", [
                'national_id' => $nationalId,
            ]);

        return $this->handleResponse($response);
    }

    /**
     * Handle API response and standardize output
     */
    protected function handleResponse($response): array
    {
        if ($response->successful()) {
            $data = $response->json();

            // Standardize the response format
            return [
                'status' => $data['status'] ?? 'success',
                'message' => $data['message'] ?? 'Identity verified successfully',
                'data' => $data['data'] ?? $data,
                'errors' => $data['errors'] ?? null,
                'timestamp' => now()->toIso8601String(),
                'request_id' => $response->header('X-Request-ID') ?? Str::uuid()->toString()
            ];
        }

        // Handle error responses
        $statusCode = $response->status();
        $errorData = $response->json();

        return [
            'status' => 'error',
            'message' => $errorData['message'] ?? 'Failed to verify identity',
            'data' => null,
            'errors' => [
                'code' => $errorData['code'] ?? "HTTP_{$statusCode}",
                'description' => $errorData['description'] ?? $response->body()
            ],
            'timestamp' => now()->toIso8601String(),
            'request_id' => $response->header('X-Request-ID') ?? Str::uuid()->toString()
        ];
    }
}