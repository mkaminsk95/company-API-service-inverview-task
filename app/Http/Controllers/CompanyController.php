<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    /**
     * @return Collection<int, Company>
     */
    public function index(): Collection
    {
        return Company::all();
    }

    public function store(StoreCompanyRequest $request): JsonResponse
    {
        $company = Company::create($request->validated());

        return response()->json($company, 201);
    }

    public function show(int $id): JsonResponse
    {
        $company = Company::findOrFail($id);

        return response()->json($company);
    }

    public function update(UpdateCompanyRequest $request, int $id): JsonResponse
    {
        $company = Company::findOrFail($id);
        $data = $request->validated();

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
