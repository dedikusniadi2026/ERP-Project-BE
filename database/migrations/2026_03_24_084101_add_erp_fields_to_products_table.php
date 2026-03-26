<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku')->nullable()->unique()->after('id');
            $table->foreignId('category_id')->nullable()->after('sku')->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('warehouse_id')->nullable()->after('category_id')->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->decimal('cost_price', 12, 2)->default(0)->after('price');
            $table->string('unit', 30)->default('pcs')->after('cost_price');
            $table->boolean('is_active')->default(true)->after('stock');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
            $table->dropConstrainedForeignId('warehouse_id');
            $table->dropColumn(['sku', 'cost_price', 'unit', 'is_active']);
        });
    }
};
