<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Helpers\PhoneHelper;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    const PHONE_REGEX = "/^[\+]?[(]?[0-9]{0,3}[)]?[-\s]?[0-9]{0,4}[-\s]?[0-9]{0,4}[-\s]?[0-9]{0,4}$/";

    /**
     * @return array<string, array<int, string>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'sometimes|required|string|max:255',
            'second_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|max:255|email|unique:employees,email,'.$this->employee,
            'phone' => ['sometimes', 'required', 'string', 'regex:'.phoneHelper::PHONE_VALIDATION_REGEX, 'unique:employees,phone,'.$this->employee],
            'company_id' => 'sometimes|required|exists:companies,id',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone' => phoneHelper::cleanPhone(strval($this->phone)),
        ]);
    }
}
