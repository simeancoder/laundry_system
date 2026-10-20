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
        Schema::dropIfExists('promotions');

        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('type', 100)->default('Percentage Discount');
            $table->decimal('discount_value', 10, 2)->default(0.00);
            $table->string('discount_unit', 10)->default('%');
            $table->string('start_date', 50)->nullable();
            $table->string('end_date', 50)->nullable();
            $table->string('coupon_code', 100)->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['Active', 'Expired', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
