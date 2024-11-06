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
            'first_name' => 'sometimes|required|string',
            'second_name' => 'sometimes|required|string',
            'email' => 'sometimes|required|string|email|unique:employees,email,'.$this->employee->email,
            'phone' => 'sometimes|required|string|digits|unique:employees'.$this->employee->phone,
            'company_id' => 'sometimes|required|exists:companies,id',
        ];
    }
}
