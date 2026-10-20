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
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->string('payment_id', 50)->unique();
                $table->string('order_number', 50)->index();
                $table->string('customer_name', 150)->index();
                $table->string('customer_initials', 10)->nullable();
                $table->string('avatar_color', 50)->default('bg-blue-100 text-blue-700');
                $table->decimal('amount', 10, 2)->default(0.00);
                $table->string('payment_method', 50)->default('Cash')->index();
                $table->string('status', 50)->default('COMPLETED')->index();
                $table->dateTime('payment_date')->index();
                $table->string('reference_no', 100)->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
