<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE employees MODIFY status ENUM('active','inactive','resigned') NOT NULL DEFAULT 'active'");
        DB::statement("ALTER TABLE purchase_orders MODIFY status ENUM('draft','submitted','approved','posted','completed','reversed','cancelled') NOT NULL DEFAULT 'draft'");
        DB::statement("ALTER TABLE sales_orders MODIFY status ENUM('draft','submitted','approved','posted','completed','reversed','cancelled') NOT NULL DEFAULT 'draft'");
        DB::statement("ALTER TABLE invoices MODIFY status ENUM('draft','submitted','approved','unpaid','partial','paid','reversed','cancelled') NOT NULL DEFAULT 'unpaid'");
        DB::statement("ALTER TABLE payments MODIFY method ENUM('cash','bank_transfer','giro','credit_card') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE employees MODIFY status ENUM('active','inactive','on_leave') NOT NULL DEFAULT 'active'");
        DB::statement("ALTER TABLE purchase_orders MODIFY status ENUM('draft','approved','received','cancelled') NOT NULL DEFAULT 'draft'");
        DB::statement("ALTER TABLE sales_orders MODIFY status ENUM('draft','confirmed','shipped','completed','cancelled') NOT NULL DEFAULT 'draft'");
        DB::statement("ALTER TABLE invoices MODIFY status ENUM('unpaid','partial','paid','overdue','cancelled') NOT NULL DEFAULT 'unpaid'");
        DB::statement("ALTER TABLE payments MODIFY method ENUM('cash','bank_transfer','credit_card','e_wallet','other') NOT NULL");
    }
};
