<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'nip' => 'required|string|digits:10|unique:companies',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string|regex:/^\d{2}-\d{3}$/',
        ];
    }
}
