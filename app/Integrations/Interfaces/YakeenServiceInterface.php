<?php

namespace App\Integrations\Interfaces;

interface YakeenServiceInterface
{
    public function verifyIdentity(string $nationalId): array;
}