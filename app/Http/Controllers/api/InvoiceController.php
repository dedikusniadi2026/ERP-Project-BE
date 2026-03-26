<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 10), 1), 100);

        $data = Invoice::query()
            ->with(['customer', 'salesOrder', 'user', 'payments'])
            ->latest()
            ->paginate($perPage);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = $this->validatePayload($request);
        $total = ((float) ($data['subtotal'] ?? 0)) + ((float) ($data['tax'] ?? 0));

        $invoice = Invoice::create([
            'invoice_number' => $data['invoice_number'] ?? $this->generateNumber(),
            'sales_order_id' => $data['sales_order_id'] ?? null,
            'customer_id' => $data['customer_id'],
            'user_id' => $request->user()->id,
            'invoice_date' => $data['invoice_date'],
            'due_date' => $data['due_date'] ?? null,
            'status' => $data['status'] ?? 'unpaid',
            'subtotal' => $data['subtotal'] ?? 0,
            'tax' => $data['tax'] ?? 0,
            'total' => $total,
            'paid_amount' => 0,
            'balance_due' => $total,
            'notes' => $data['notes'] ?? null,
        ]);

        return response()->json([
            'message' => 'Invoice berhasil dibuat',
            'data' => $invoice->load(['customer', 'salesOrder', 'user', 'payments']),
        ], 201);
    }

    public function show(Invoice $invoice)
    {
        return response()->json([
            'data' => $invoice->load(['customer', 'salesOrder', 'user', 'payments']),
        ]);
    }

    public function update(Request $request, Invoice $invoice)
    {
        $data = $this->validatePayload($request, $invoice->id, true);

        if (isset($data['subtotal']) || isset($data['tax'])) {
            $subtotal = (float) ($data['subtotal'] ?? $invoice->subtotal);
            $tax = (float) ($data['tax'] ?? $invoice->tax);
            $total = $subtotal + $tax;
            $paidAmount = (float) $invoice->paid_amount;
            $balance = max($total - $paidAmount, 0);

            $data['total'] = $total;
            $data['balance_due'] = $balance;

            if ($paidAmount <= 0) {
                $data['status'] = 'unpaid';
            } elseif ($paidAmount >= $total) {
                $data['status'] = 'paid';
            } else {
                $data['status'] = 'partial';
            }
        }

        $invoice->update($data);

        return response()->json([
            'message' => 'Invoice berhasil diupdate',
            'data' => $invoice->fresh()->load(['customer', 'salesOrder', 'user', 'payments']),
        ]);
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return response()->json([
            'message' => 'Invoice berhasil dihapus',
        ]);
    }

    private function validatePayload(Request $request, ?int $id = null, bool $isUpdate = false): array
    {
        $required = $isUpdate ? 'sometimes' : 'required';

        return $request->validate([
            'invoice_number' => ['nullable', 'string', 'max:100', Rule::unique('invoices', 'invoice_number')->ignore($id)],
            'sales_order_id' => ['nullable', 'exists:sales_orders,id'],
            'customer_id' => [$required, 'exists:customers,id'],
            'invoice_date' => [$required, 'date'],
            'due_date' => ['nullable', 'date'],
            'status' => ['sometimes', Rule::in(['draft', 'submitted', 'approved', 'unpaid', 'partial', 'paid', 'reversed', 'cancelled'])],
            'subtotal' => ['nullable', 'numeric', 'min:0'],
            'tax' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);
    }

    private function generateNumber(): string
    {
        return 'INV-' . now()->format('YmdHis');
    }
}
