<?php

declare(strict_types=1);

namespace App\Http\Helpers;

class PhoneHelper
{
    const PHONE_VALIDATION_REGEX = "/^[\+]?[(]?[0-9]{0,3}[)]?[-\s]?[0-9]{0,4}[-\s]?[0-9]{0,4}[-\s]?[0-9]{0,4}$/";

    static function cleanPhone(string $phone): string
    {
        return str_replace([' ', '-', '(', ')'], '', $phone);
    }
}
