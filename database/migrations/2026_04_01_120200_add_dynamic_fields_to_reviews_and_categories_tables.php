<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table): void {
            $table->string('name')->nullable()->after('id');
            $table->string('role')->nullable()->after('name');
            $table->text('quote')->nullable()->after('role');
            $table->unsignedTinyInteger('rating')->default(5)->after('quote');
            $table->unsignedInteger('sort_order')->default(0)->after('rating');
            $table->boolean('is_active')->default(true)->after('sort_order');
        });

        Schema::table('categories', function (Blueprint $table): void {
            $table->string('image')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table): void {
            $table->dropColumn(['name', 'role', 'quote', 'rating', 'sort_order', 'is_active']);
        });

        Schema::table('categories', function (Blueprint $table): void {
            $table->dropColumn('image');
        });
    }
};
