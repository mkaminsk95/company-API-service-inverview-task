<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;

class EmployeeController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Employee::all());
    }

    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        $employee = Employee::create($request->validated());

        return response()->json($employee, 201);
    }

    public function show(int $id): JsonResponse
    {
        $employee = Employee::findOrFail($id);

        return response()->json($employee);
    }

    public function update(UpdateEmployeeRequest $request, string $id): JsonResponse
    {
        $employee = Employee::findOrFail($id);
        $data = $request->validated();

        $employee->update($data);

        return response()->json($employee);
    }

    public function destroy(int $id): JsonResponse
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return response()->json(null, 204);
    }
}
