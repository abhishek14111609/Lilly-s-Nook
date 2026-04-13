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
            $table->string('payment_status', 30)->default('pending')->after('payment_method');
            $table->string('invoice_number', 50)->nullable()->unique()->after('payment_status');
            $table->string('razorpay_order_id', 100)->nullable()->unique()->after('invoice_number');
            $table->string('razorpay_payment_id', 100)->nullable()->index()->after('razorpay_order_id');
            $table->string('razorpay_signature', 255)->nullable()->after('razorpay_payment_id');
            $table->timestamp('paid_at')->nullable()->after('razorpay_signature');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table): void {
            $table->dropColumn([
                'payment_status',
                'invoice_number',
                'razorpay_order_id',
                'razorpay_payment_id',
                'razorpay_signature',
                'paid_at',
            ]);
        });
    }
};
