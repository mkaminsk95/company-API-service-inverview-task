<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'first_name' => 'sometimes|required|string:255',
            'second_name' => 'sometimes|required|string:255',
            'email' => 'sometimes|required|string:255|email|unique:employees,email,'.$this->employee->email,
            'phone' => 'sometimes|required|string|digits:15|unique:employees'.$this->employee->phone,
            'company_id' => 'sometimes|required|exists:companies,id',
        ];
    }
}
