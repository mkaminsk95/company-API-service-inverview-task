<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Models\Employee;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }
        return response()->json($employee);
    }

    public function update(Request $request, string $id): JsonResponse
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
