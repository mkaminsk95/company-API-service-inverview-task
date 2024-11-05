<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * @return Collection<int, Company>
     */
    public function index(): Collection
    {
        return Company::all();
    }

    public function store(Request $request): JsonResponse
    {
        // TODO: Move validations to separate classes
        // TODO: Add validation for nip formating
        $data = $request->validate([
            'name' => 'required|string',
            'nip' => 'required|string|size:10|unique:companies',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string|regex:/^\d{2}-\d{3}$/',
        ]);

        $company = Company::create($data);

        return response()->json($company, 201);
    }

    public function show(int $id): JsonResponse
    {
        $company = Company::findOrFail($id);
        return response()->json($company);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $company = Company::findOrFail($id);

        // TODO: Add validation for nip formating
        $data = $request->validate([
            'name' => 'sometimes|required|string',
            'nip' => 'sometimes|required|string|size:10|unique:companies,nip,' . $id,
            'address' => 'sometimes|required|string',
            'city' => 'sometimes|required|string',
            'postal_code' => 'sometimes|required|string|regex:/^\d{2}-\d{3}$/',
        ]);

        $company->update($data);

        return response()->json($company);
    }

    public function destroy(int $id): JsonResponse
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return response()->json(null, 204);
    }
}
