<?php

namespace App\Interfaces;

interface YakeenServiceInterface
{
    public function verifyIdentity(string $nationalId): array;
}