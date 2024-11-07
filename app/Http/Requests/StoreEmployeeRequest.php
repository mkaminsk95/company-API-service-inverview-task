<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    const PHONE_REGEX = "/^([0|\+[0-9]{1,5})?([0-9]{9})$/";

    /**
     * @return array<string, array<int, string>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:employees',
            'phone' => ['sometimes', 'required', 'string', 'regex:' . self::PHONE_REGEX, 'unique:employees'],
            'company_id' => 'required|exists:companies,id',
        ];
    }
}
