<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 10), 1), 100);

        return response()->json(
            Warehouse::query()->latest()->paginate($perPage)
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:warehouses,code'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $warehouse = Warehouse::create($data);

        return response()->json([
            'message' => 'Warehouse berhasil dibuat',
            'data' => $warehouse,
        ], 201);
    }

    public function show(Warehouse $warehouse)
    {
        return response()->json([
            'data' => $warehouse,
        ]);
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $data = $request->validate([
            'code' => ['sometimes', 'string', 'max:50', Rule::unique('warehouses', 'code')->ignore($warehouse->id)],
            'name' => ['sometimes', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $warehouse->update($data);

        return response()->json([
            'message' => 'Warehouse berhasil diupdate',
            'data' => $warehouse,
        ]);
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();

        return response()->json([
            'message' => 'Warehouse berhasil dihapus',
        ]);
    }
}
