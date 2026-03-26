<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 10), 1), 100);

        return response()->json(
            Employee::query()->latest()->paginate($perPage)
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_code' => ['required', 'string', 'max:50', 'unique:employees,employee_code'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:employees,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'position' => ['nullable', 'string', 'max:255'],
            'hire_date' => ['nullable', 'date'],
            'status' => ['sometimes', Rule::in(['active', 'inactive', 'resigned'])],
        ]);

        $employee = Employee::create($data);

        return response()->json([
            'message' => 'Employee berhasil dibuat',
            'data' => $employee,
        ], 201);
    }

    public function show(Employee $employee)
    {
        return response()->json([
            'data' => $employee,
        ]);
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'employee_code' => ['sometimes', 'string', 'max:50', Rule::unique('employees', 'employee_code')->ignore($employee->id)],
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('employees', 'email')->ignore($employee->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'position' => ['nullable', 'string', 'max:255'],
            'hire_date' => ['nullable', 'date'],
            'status' => ['sometimes', Rule::in(['active', 'inactive', 'resigned'])],
        ]);

        $employee->update($data);

        return response()->json([
            'message' => 'Employee berhasil diupdate',
            'data' => $employee,
        ]);
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json([
            'message' => 'Employee berhasil dihapus',
        ]);
    }
}
