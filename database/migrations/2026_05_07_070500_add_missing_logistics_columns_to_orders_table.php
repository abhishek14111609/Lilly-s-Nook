<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table): void {
            if (! Schema::hasColumn('orders', 'shipping_fee')) {
                $table->decimal('shipping_fee', 10, 2)->default(0)->after('total');
            }

            if (! Schema::hasColumn('orders', 'tax_amount')) {
                $table->decimal('tax_amount', 10, 2)->default(0)->after('shipping_fee');
            }

            if (! Schema::hasColumn('orders', 'awb_number')) {
                $table->string('awb_number')->nullable()->after('tax_amount');
            }

            if (! Schema::hasColumn('orders', 'courier_name')) {
                $table->string('courier_name')->nullable()->after('awb_number');
            }

            if (! Schema::hasColumn('orders', 'shipping_status')) {
                $table->string('shipping_status')->default('pending')->after('courier_name');
            }

            if (! Schema::hasColumn('orders', 'shipping_address_id')) {
                $table->foreignId('shipping_address_id')->nullable()->constrained('addresses')->nullOnDelete()->after('shipping_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table): void {
            if (Schema::hasColumn('orders', 'shipping_address_id')) {
                $table->dropForeign(['shipping_address_id']);
            }

            $dropColumns = [];

            foreach (['shipping_fee', 'tax_amount', 'awb_number', 'courier_name', 'shipping_status', 'shipping_address_id'] as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $dropColumns[] = $column;
                }
            }

            if ($dropColumns !== []) {
                $table->dropColumn($dropColumns);
            }
        });
    }
};
