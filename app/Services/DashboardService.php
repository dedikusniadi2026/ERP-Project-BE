<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Delivery;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PurchaseOrder;
use App\Models\Product;
use App\Models\Receipt;
use App\Models\SalesOrder;
use App\Models\StockMovement;
use App\Models\Supplier;
use App\Models\User;


class DashboardService
{
    public function stats(): array
    {
        return [
            'users' => User::count(),
            'products' => Product::count(),
            'customers' => Customer::count(),
            'suppliers' => Supplier::count(),
            'purchase_orders' => PurchaseOrder::count(),
            'sales_orders' => SalesOrder::count(),
            'deliveries' => Delivery::count(),
            'receipts' => Receipt::count(),
            'invoices' => Invoice::count(),
            'payments' => Payment::count(),
            'stock_movements' => StockMovement::count(),
        ];
    }
}
