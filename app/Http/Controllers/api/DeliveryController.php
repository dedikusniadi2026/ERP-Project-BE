<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DeliveryController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 10), 1), 100);

        $data = Delivery::query()
            ->with(['salesOrder', 'customer', 'user'])
            ->latest()
            ->paginate($perPage);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = $this->validatePayload($request);

        $delivery = Delivery::create([
            'delivery_number' => $data['delivery_number'] ?? $this->generateNumber(),
            'sales_order_id' => $data['sales_order_id'],
            'customer_id' => $data['customer_id'],
            'user_id' => $request->user()->id,
            'delivery_date' => $data['delivery_date'],
            'status' => $data['status'] ?? 'draft',
            'notes' => $data['notes'] ?? null,
        ]);

        return response()->json([
            'message' => 'Delivery berhasil dibuat',
            'data' => $delivery->load(['salesOrder', 'customer', 'user']),
        ], 201);
    }

    public function show(Delivery $delivery)
    {
        return response()->json([
            'data' => $delivery->load(['salesOrder', 'customer', 'user']),
        ]);
    }

    public function update(Request $request, Delivery $delivery)
    {
        $data = $this->validatePayload($request, $delivery->id, true);

        $delivery->update($data);

        return response()->json([
            'message' => 'Delivery berhasil diupdate',
            'data' => $delivery->fresh()->load(['salesOrder', 'customer', 'user']),
        ]);
    }

    public function destroy(Delivery $delivery)
    {
        $delivery->delete();

        return response()->json([
            'message' => 'Delivery berhasil dihapus',
        ]);
    }

    private function validatePayload(Request $request, ?int $id = null, bool $isUpdate = false): array
    {
        $required = $isUpdate ? 'sometimes' : 'required';

        return $request->validate([
            'delivery_number' => ['nullable', 'string', 'max:100', Rule::unique('deliveries', 'delivery_number')->ignore($id)],
            'sales_order_id' => [$required, 'exists:sales_orders,id'],
            'customer_id' => [$required, 'exists:customers,id'],
            'delivery_date' => [$required, 'date'],
            'status' => ['sometimes', Rule::in(['draft', 'submitted', 'approved', 'shipped', 'completed', 'cancelled'])],
            'notes' => ['nullable', 'string'],
        ]);
    }

    private function generateNumber(): string
    {
        return 'DO-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));
    }
}
