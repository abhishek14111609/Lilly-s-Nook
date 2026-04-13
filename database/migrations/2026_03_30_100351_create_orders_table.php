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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('address', 255);
            $table->string('city', 100);
            $table->string('zip', 20);
            $table->string('phone', 20);
            $table->string('email', 150);
            $table->decimal('total', 10, 2);
            $table->string('payment_method', 50)->default('razorpay');
            $table->string('status', 50)->default('placed');
            $table->timestamp('ordered_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
