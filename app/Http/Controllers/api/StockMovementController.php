<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StockMovementController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 10), 1), 100);

        $data = StockMovement::query()
            ->with(['product', 'warehouse', 'user'])
            ->latest()
            ->paginate($perPage);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'movement_number' => ['nullable', 'string', 'max:100', 'unique:stock_movements,movement_number'],
            'product_id' => ['required', 'exists:products,id'],
            'warehouse_id' => ['nullable', 'exists:warehouses,id'],
            'type' => ['required', Rule::in(['in', 'out', 'adjustment'])],
            'quantity' => ['required', 'numeric', 'gt:0'],
            'reference_type' => ['nullable', 'string', 'max:100'],
            'reference_id' => ['nullable', 'integer'],
            'notes' => ['nullable', 'string'],
            'moved_at' => ['nullable', 'date'],
        ]);

        $stockMovement = DB::transaction(function () use ($data, $request) {
            $product = Product::lockForUpdate()->findOrFail($data['product_id']);
            $currentStock = (float) $product->stock;

            $nextStock = match ($data['type']) {
                'in' => $currentStock + (float) $data['quantity'],
                'out' => $currentStock - (float) $data['quantity'],
                default => (float) $data['quantity'],
            };

            if ($nextStock < 0) {
                abort(422, 'Stok tidak mencukupi untuk transaksi keluar.');
            }

            $product->update(['stock' => $nextStock]);

            return StockMovement::create([
                'movement_number' => $data['movement_number'] ?? $this->generateNumber(),
                'product_id' => $data['product_id'],
                'warehouse_id' => $data['warehouse_id'] ?? $product->warehouse_id,
                'user_id' => $request->user()->id,
                'type' => $data['type'],
                'quantity' => $data['quantity'],
                'balance_after' => $nextStock,
                'reference_type' => $data['reference_type'] ?? null,
                'reference_id' => $data['reference_id'] ?? null,
                'notes' => $data['notes'] ?? null,
                'moved_at' => $data['moved_at'] ?? now(),
            ]);
        });

        return response()->json([
            'message' => 'Stock movement berhasil dibuat',
            'data' => $stockMovement->load(['product', 'warehouse', 'user']),
        ], 201);
    }

    public function show(StockMovement $stockMovement)
    {
        return response()->json([
            'data' => $stockMovement->load(['product', 'warehouse', 'user']),
        ]);
    }

    public function update(Request $request, StockMovement $stockMovement)
    {
        $data = $request->validate([
            'warehouse_id' => ['nullable', 'exists:warehouses,id'],
            'reference_type' => ['nullable', 'string', 'max:100'],
            'reference_id' => ['nullable', 'integer'],
            'notes' => ['nullable', 'string'],
            'moved_at' => ['nullable', 'date'],
        ]);

        $stockMovement->update($data);

        return response()->json([
            'message' => 'Stock movement berhasil diupdate',
            'data' => $stockMovement->fresh()->load(['product', 'warehouse', 'user']),
        ]);
    }

    public function destroy(StockMovement $stockMovement)
    {
        return response()->json([
            'message' => 'Stock movement tidak boleh dihapus untuk menjaga audit trail.',
        ], 422);
    }

    private function generateNumber(): string
    {
        return 'MOV-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));
    }
}
