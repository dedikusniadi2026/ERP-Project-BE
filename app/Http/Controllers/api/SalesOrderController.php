<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SalesOrderController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 10), 1), 100);

        $data = SalesOrder::query()
            ->with(['customer', 'user', 'items.product'])
            ->latest()
            ->paginate($perPage);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $this->validatePayload($request);

        $salesOrder = DB::transaction(function () use ($validated, $request) {
            [$subtotal, $items] = $this->buildItems($validated['items']);
            $tax = (float) ($validated['tax'] ?? 0);
            $total = $subtotal + $tax;

            $so = SalesOrder::create([
                'so_number' => $validated['so_number'] ?? $this->generateNumber(),
                'customer_id' => $validated['customer_id'],
                'user_id' => $request->user()->id,
                'order_date' => $validated['order_date'],
                'status' => $validated['status'] ?? 'draft',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'notes' => $validated['notes'] ?? null,
            ]);

            $so->items()->createMany($items);

            return $so;
        });

        return response()->json([
            'message' => 'Sales order berhasil dibuat',
            'data' => $salesOrder->load(['customer', 'user', 'items.product']),
        ], 201);
    }

    public function show(SalesOrder $salesOrder)
    {
        return response()->json([
            'data' => $salesOrder->load(['customer', 'user', 'items.product']),
        ]);
    }

    public function update(Request $request, SalesOrder $salesOrder)
    {
        $validated = $this->validatePayload($request, $salesOrder->id);

        DB::transaction(function () use ($validated, $salesOrder) {
            [$subtotal, $items] = $this->buildItems($validated['items']);
            $tax = (float) ($validated['tax'] ?? 0);
            $total = $subtotal + $tax;

            $salesOrder->update([
                'so_number' => $validated['so_number'] ?? $salesOrder->so_number,
                'customer_id' => $validated['customer_id'],
                'order_date' => $validated['order_date'],
                'status' => $validated['status'] ?? $salesOrder->status,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'notes' => $validated['notes'] ?? null,
            ]);

            $salesOrder->items()->delete();
            $salesOrder->items()->createMany($items);
        });

        return response()->json([
            'message' => 'Sales order berhasil diupdate',
            'data' => $salesOrder->fresh()->load(['customer', 'user', 'items.product']),
        ]);
    }

    public function destroy(SalesOrder $salesOrder)
    {
        $salesOrder->delete();

        return response()->json([
            'message' => 'Sales order berhasil dihapus',
        ]);
    }

    private function validatePayload(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'so_number' => ['nullable', 'string', 'max:100', Rule::unique('sales_orders', 'so_number')->ignore($id)],
            'customer_id' => ['required', 'exists:customers,id'],
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
        return 'SO-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));
    }
}
