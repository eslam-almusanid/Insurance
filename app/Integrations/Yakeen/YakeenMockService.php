<?php

namespace App\Integrations\Yakeen;

use App\Integrations\Interfaces\YakeenServiceInterface;
use Illuminate\Support\Str;

class YakeenMockService implements YakeenServiceInterface
{
    public function verifyIdentity(string $nationalId): array
    {
        if (strlen($nationalId) === 10 && preg_match('/^[1-2][0-9]{9}$/', $nationalId)) {
            return [
                'status' => 'success',
                'message' => 'Identity verified successfully',
                'data' => [
                    'national_id' => $nationalId,
                    'full_name_ar' => 'محمد عبدالله العتيبي',
                    'full_name_en' => 'Mohammed Abdullah Al-Otaibi',
                    'phone_number' => '0500000000',
                    'date_of_birth_hijri' => '1400-05-15',
                    'date_of_birth_gregorian' => '1980-03-22',
                    'gender' => 'male',
                    'nationality' => 'Saudi',
                    'id_issue_date' => '1435-08-10',
                    'id_expiry_date' => '1445-08-09',
                    'status_code' => '200'
                ],
                'errors' => null,
                'timestamp' => now()->toIso8601String(),
                'request_id' => Str::uuid()->toString()
            ];
        }

        return [
            'status' => 'error',
            'message' => 'Invalid National ID',
            'data' => null,
            'errors' => [
                'code' => 'INVALID_ID',
                'description' => 'The provided National ID does not exist or is invalid.'
            ],
            'timestamp' => now()->toIso8601String(),
            'request_id' => Str::uuid()->toString()
        ];
    }
}