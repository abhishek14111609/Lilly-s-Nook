<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table): void {
            if (! Schema::hasColumn('reviews', 'product_id')) {
                $table->foreignId('product_id')->nullable()->after('id')->constrained()->nullOnDelete();
            }

            if (! Schema::hasColumn('reviews', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('product_id')->constrained()->nullOnDelete();
            }

            $table->index(['product_id', 'is_active']);
            $table->index(['user_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table): void {
            $table->dropIndex(['product_id', 'is_active']);
            $table->dropIndex(['user_id', 'product_id']);

            if (Schema::hasColumn('reviews', 'product_id')) {
                $table->dropConstrainedForeignId('product_id');
            }

            if (Schema::hasColumn('reviews', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });
    }
};
