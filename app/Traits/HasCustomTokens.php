<?php

namespace App\Traits;

use App\Enums\TokenTypesEnum;
use Illuminate\Support\Str;
use Laravel\Sanctum\NewAccessToken;


trait HasCustomTokens
{
    /**
     * Create a new personal access token.
     *
     * @param  string  $name
     * @param  array  $abilities
     * @param  \DateTime|null  $expiresAt
     * @return \Laravel\Sanctum\NewAccessToken
     */
    public function customToken(TokenTypesEnum $name, array $abilities = ['*'], ?\DateTime $expiresAt = null)
    {
        $plainTextToken = sprintf(
            '%s%s%s',
            config('sanctum.token_prefix', ''),
            $tokenEntropy = Str::random(config('sanctum.token_length', 50)),
            hash('crc32b', $tokenEntropy)
        );

        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken),
            'abilities' => $abilities,
            'expires_at' => $expiresAt ?? now()->addMinutes(config('sanctum.expiration')),
        ]);

        return new NewAccessToken($token, $token->getKey().'|'.$plainTextToken);

    }
}