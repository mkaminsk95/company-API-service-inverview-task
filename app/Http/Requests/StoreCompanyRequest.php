<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    public function rules(): array
    {
        // TODO: Add validation for nip formating
        return [
            'name' => 'required|string',
            'nip' => 'required|string|size:10|unique:companies',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string|regex:/^\d{2}-\d{3}$/',
        ];
    }
}
