<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    const PHONE_REGEX = "/^([0|\+[0-9]{1,5})?([0-9]{3,9})$/";

    /**
     * @return array<string, array<int, string>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'sometimes|required|string|max:255',
            'second_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|max:255|email|unique:employees,email,'.$this->employee,
            'phone' => ['sometimes', 'required', 'string', 'regex:'.self::PHONE_REGEX, 'unique:employees,phone,'.$this->employee],
            'company_id' => 'sometimes|required|exists:companies,id',
        ];
    }
}
