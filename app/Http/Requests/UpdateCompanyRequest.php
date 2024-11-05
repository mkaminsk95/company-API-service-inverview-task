<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    public function rules(): array
    {
        // TODO: Add validation for nip formating
        return [
            'name' => 'sometimes|required|string',
            'nip' => 'sometimes|required|string|size:10|unique:companies,nip,' . $this->company,
            'address' => 'sometimes|required|string',
            'city' => 'sometimes|required|string',
            'postal_code' => 'sometimes|required|string|regex:/^\d{2}-\d{3}$/',
        ];
    }
}
