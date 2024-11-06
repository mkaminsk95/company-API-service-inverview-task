<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string:255',
            'second_name' => 'required|string:255',
            'email' => 'required|string:255|email|unique:employees',
            'phone' => 'sometimes|required|string|digits:15|unique:employees',
            'company_id' => 'required|exists:companies,id',
        ];
    }
}
