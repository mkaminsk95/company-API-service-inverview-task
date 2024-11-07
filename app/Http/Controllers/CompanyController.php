<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Company::all(), JsonResponse::HTTP_OK);
    }

    public function store(StoreCompanyRequest $request): JsonResponse
    {
        $company = Company::create($request->validated());

        return response()->json($company, JsonResponse::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        $company = Company::findOrFail($id);

        return response()->json($company, JsonResponse::HTTP_OK);
    }

    public function update(UpdateCompanyRequest $request, int $id): JsonResponse
    {
        $company = Company::findOrFail($id);
        $data = $request->validated();

        $company->update($data);

        return response()->json($company, JsonResponse::HTTP_OK);
    }

    public function destroy(int $id): JsonResponse
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
