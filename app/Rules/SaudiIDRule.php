<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SaudiIDRule implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    // e.g 1058529940
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $id = trim($value);
        
        if (!is_numeric($id)) {
            $fail('The :attribute must be numeric.');
            return;
        }

        if (strlen($id) !== 10) {
            $fail('The :attribute must be exactly 10 digits.');
            return;
        }

        $type = substr($id, 0, 1);
        if ($type != 2 && $type != 1) {
            $fail('The :attribute must start with either 1 or 2.');
            return;
        }

        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            if ($i % 2 == 0) {
                $ZFOdd = str_pad((substr($id, $i, 1) * 2), 2, "0", STR_PAD_LEFT);
                $sum += substr($ZFOdd, 0, 1) + substr($ZFOdd, 1, 1);
            } else {
                $sum += substr($id, $i, 1);
            }
        }

        if ($sum % 10 !== 0) {
            $fail('The :attribute is not a valid Saudi ID number.');
        }
    }
} 