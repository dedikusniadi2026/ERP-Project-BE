<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PurchaseOrderController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 10), 1), 100);

        $data = PurchaseOrder::query()
            ->with(['supplier', 'user', 'items.product'])
            ->latest()
            ->paginate($perPage);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $this->validatePayload($request);

        $purchaseOrder = DB::transaction(function () use ($validated, $request) {
            [$subtotal, $items] = $this->buildItems($validated['items']);
            $tax = (float) ($validated['tax'] ?? 0);
            $total = $subtotal + $tax;

            $po = PurchaseOrder::create([
                'po_number' => $validated['po_number'] ?? $this->generateNumber(),
                'supplier_id' => $validated['supplier_id'],
                'user_id' => $request->user()->id,
                'order_date' => $validated['order_date'],
                'status' => $validated['status'] ?? 'draft',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'notes' => $validated['notes'] ?? null,
            ]);

            $po->items()->createMany($items);

            return $po;
        });

        return response()->json([
            'message' => 'Purchase order berhasil dibuat',
            'data' => $purchaseOrder->load(['supplier', 'user', 'items.product']),
        ], 201);
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        return response()->json([
            'data' => $purchaseOrder->load(['supplier', 'user', 'items.product']),
        ]);
    }

    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        $validated = $this->validatePayload($request, $purchaseOrder->id);

        DB::transaction(function () use ($validated, $purchaseOrder) {
            [$subtotal, $items] = $this->buildItems($validated['items']);
            $tax = (float) ($validated['tax'] ?? 0);
            $total = $subtotal + $tax;

            $purchaseOrder->update([
                'po_number' => $validated['po_number'] ?? $purchaseOrder->po_number,
                'supplier_id' => $validated['supplier_id'],
                'order_date' => $validated['order_date'],
                'status' => $validated['status'] ?? $purchaseOrder->status,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'notes' => $validated['notes'] ?? null,
            ]);

            $purchaseOrder->items()->delete();
            $purchaseOrder->items()->createMany($items);
        });

        return response()->json([
            'message' => 'Purchase order berhasil diupdate',
            'data' => $purchaseOrder->fresh()->load(['supplier', 'user', 'items.product']),
        ]);
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->delete();

        return response()->json([
            'message' => 'Purchase order berhasil dihapus',
        ]);
    }

    private function validatePayload(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'po_number' => ['nullable', 'string', 'max:100', Rule::unique('purchase_orders', 'po_number')->ignore($id)],
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'order_date' => ['required', 'date'],
            'status' => ['sometimes', Rule::in(['draft', 'submitted', 'approved', 'posted', 'completed', 'reversed', 'cancelled'])],
            'tax' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.qty' => ['required', 'numeric', 'gt:0'],
            'items.*.price' => ['required', 'numeric', 'min:0'],
        ]);
    }

    private function buildItems(array $itemsInput): array
    {
        $items = [];
        $subtotal = 0.0;

        foreach ($itemsInput as $item) {
            $lineTotal = (float) $item['qty'] * (float) $item['price'];
            $subtotal += $lineTotal;
            $items[] = [
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'total' => $lineTotal,
            ];
        }

        return [$subtotal, $items];
    }

    private function generateNumber(): string
    {
        return 'PO-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));
    }
}
