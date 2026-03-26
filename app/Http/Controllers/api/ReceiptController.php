<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ReceiptController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 10), 1), 100);

        $data = Receipt::query()
            ->with(['purchaseOrder', 'supplier', 'user'])
            ->latest()
            ->paginate($perPage);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = $this->validatePayload($request);

        $receipt = Receipt::create([
            'receipt_number' => $data['receipt_number'] ?? $this->generateNumber(),
            'purchase_order_id' => $data['purchase_order_id'],
            'supplier_id' => $data['supplier_id'],
            'user_id' => $request->user()->id,
            'receipt_date' => $data['receipt_date'],
            'status' => $data['status'] ?? 'draft',
            'notes' => $data['notes'] ?? null,
        ]);

        return response()->json([
            'message' => 'Receipt berhasil dibuat',
            'data' => $receipt->load(['purchaseOrder', 'supplier', 'user']),
        ], 201);
    }

    public function show(Receipt $receipt)
    {
        return response()->json([
            'data' => $receipt->load(['purchaseOrder', 'supplier', 'user']),
        ]);
    }

    public function update(Request $request, Receipt $receipt)
    {
        $data = $this->validatePayload($request, $receipt->id, true);

        $receipt->update($data);

        return response()->json([
            'message' => 'Receipt berhasil diupdate',
            'data' => $receipt->fresh()->load(['purchaseOrder', 'supplier', 'user']),
        ]);
    }

    public function destroy(Receipt $receipt)
    {
        $receipt->delete();

        return response()->json([
            'message' => 'Receipt berhasil dihapus',
        ]);
    }

    private function validatePayload(Request $request, ?int $id = null, bool $isUpdate = false): array
    {
        $required = $isUpdate ? 'sometimes' : 'required';

        return $request->validate([
            'receipt_number' => ['nullable', 'string', 'max:100', Rule::unique('receipts', 'receipt_number')->ignore($id)],
            'purchase_order_id' => [$required, 'exists:purchase_orders,id'],
            'supplier_id' => [$required, 'exists:suppliers,id'],
            'receipt_date' => [$required, 'date'],
            'status' => ['sometimes', Rule::in(['draft', 'submitted', 'approved', 'received', 'completed', 'cancelled'])],
            'notes' => ['nullable', 'string'],
        ]);
    }

    private function generateNumber(): string
    {
        return 'GRN-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));
    }
}
