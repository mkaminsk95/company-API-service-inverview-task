<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(): Collection
    {
        return Company::get();
    }

    public function store(Request $request): JsonResponse
    {
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

    public function show($id): Company
    {
        return Company::findOrFail($id);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $company = Company::findOrFail($id);
        $company->update($request->all());

        return response()->json($company);
    }

    public function destroy($id): JsonResponse
    {
        Company::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
