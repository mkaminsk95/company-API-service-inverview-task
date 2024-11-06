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
            'first_name' => 'required|string',
            'second_name' => 'required|string',
            'email' => 'required|string|email|unique:employees',
            'phone' => 'sometimes|required|string|digits|unique:employees',
            'company_id' => 'required|exists:companies,id',
        ];
    }
}
