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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('weight', 8, 2)->nullable()->comment('Weight in kg');
            $table->string('hsn_code')->nullable();
            $table->decimal('gst_percentage', 5, 2)->default(0);
            $table->boolean('is_gst_inclusive')->default(true);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('shipping_fee', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->string('awb_number')->nullable();
            $table->string('courier_name')->nullable();
            $table->string('shipping_status')->default('pending');
            $table->foreignId('shipping_address_id')->nullable()->constrained('addresses')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['shipping_address_id']);
            $table->dropColumn(['shipping_fee', 'tax_amount', 'awb_number', 'courier_name', 'shipping_status', 'shipping_address_id']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['weight', 'hsn_code', 'gst_percentage', 'is_gst_inclusive']);
        });
    }
};
