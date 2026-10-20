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
        if (!Schema::hasTable('inventories')) {
            Schema::create('inventories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('category');
                $table->integer('stock')->default(0);
                $table->string('unit', 50)->default('L');
                $table->string('status', 50)->default('In Stock');
                $table->integer('min_stock')->default(15);
                $table->text('notes')->nullable();
                $table->string('supplier')->nullable();
                $table->decimal('unit_price', 10, 2)->default(0.00);
                $table->string('last_restocked')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
