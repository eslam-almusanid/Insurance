<?php

namespace App\Enums;

enum TokenTypesEnum: string
{
    case USER = 'user';
    case COMPANY = 'company';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
