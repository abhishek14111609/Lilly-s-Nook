<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Increase the length of the `size` column to accommodate descriptive size labels.
        // Use raw SQL to avoid adding a doctrine/dbal dependency in this project.
        DB::statement("ALTER TABLE `cart_items` MODIFY `size` VARCHAR(255) NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original length (10) — be cautious: data longer than 10 will be truncated by this operation.
        DB::statement("ALTER TABLE `cart_items` MODIFY `size` VARCHAR(10) NOT NULL");
    }
};
