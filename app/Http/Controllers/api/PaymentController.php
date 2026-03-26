<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 10), 1), 100);

        $data = Payment::query()
            ->with(['invoice', 'creator'])
            ->latest()
            ->paginate($perPage);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'payment_number' => ['nullable', 'string', 'max:100', 'unique:payments,payment_number'],
            'invoice_id' => ['required', 'exists:invoices,id'],
            'payment_date' => ['required', 'date'],
            'method' => ['required', Rule::in(['cash', 'bank_transfer', 'giro', 'credit_card'])],
            'amount' => ['required', 'numeric', 'gt:0'],
            'reference_no' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $payment = DB::transaction(function () use ($data, $request) {
            $invoice = Invoice::lockForUpdate()->findOrFail($data['invoice_id']);
            $newPaidAmount = (float) $invoice->paid_amount + (float) $data['amount'];
            $balanceDue = max((float) $invoice->total - $newPaidAmount, 0);

            $invoice->update([
                'paid_amount' => $newPaidAmount,
                'balance_due' => $balanceDue,
                'status' => $balanceDue <= 0 ? 'paid' : 'partial',
            ]);

            return Payment::create([
                'payment_number' => $data['payment_number'] ?? $this->generateNumber(),
                'invoice_id' => $data['invoice_id'],
                'created_by' => $request->user()->id,
                'payment_date' => $data['payment_date'],
                'method' => $data['method'],
                'amount' => $data['amount'],
                'reference_no' => $data['reference_no'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);
        });

        return response()->json([
            'message' => 'Payment berhasil dibuat',
            'data' => $payment->load(['invoice', 'creator']),
        ], 201);
    }

    public function show(Payment $payment)
    {
        return response()->json([
            'data' => $payment->load(['invoice', 'creator']),
        ]);
    }

    public function update(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'payment_date' => ['sometimes', 'date'],
            'method' => ['sometimes', Rule::in(['cash', 'bank_transfer', 'giro', 'credit_card'])],
            'reference_no' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $payment->update($data);

        return response()->json([
            'message' => 'Payment berhasil diupdate',
            'data' => $payment->fresh()->load(['invoice', 'creator']),
        ]);
    }

    public function destroy(Payment $payment)
    {
        DB::transaction(function () use ($payment) {
            $invoice = Invoice::lockForUpdate()->findOrFail($payment->invoice_id);
            $newPaidAmount = max((float) $invoice->paid_amount - (float) $payment->amount, 0);
            $balanceDue = max((float) $invoice->total - $newPaidAmount, 0);

            $status = 'unpaid';
            if ($newPaidAmount > 0 && $balanceDue > 0) {
                $status = 'partial';
            }
            if ($balanceDue <= 0 && $newPaidAmount > 0) {
                $status = 'paid';
            }

            $invoice->update([
                'paid_amount' => $newPaidAmount,
                'balance_due' => $balanceDue,
                'status' => $status,
            ]);

            $payment->delete();
        });

        return response()->json([
            'message' => 'Payment berhasil dihapus',
        ]);
    }

    private function generateNumber(): string
    {
        return 'PAY-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));
    }
}
