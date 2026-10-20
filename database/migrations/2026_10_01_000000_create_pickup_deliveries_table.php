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
        if (!Schema::hasTable('pickup_deliveries')) {
            Schema::create('pickup_deliveries', function (Blueprint $table) {
                $table->id();
                $table->string('order_number', 50)->index();
                $table->string('customer_name', 150)->index();
                $table->string('customer_phone', 50)->nullable();
                $table->string('service_type', 100)->index();
                $table->decimal('total_amount', 10, 2)->default(0.00);
                
                // 1. Schedule Pickup fields
                $table->date('pickup_date')->nullable()->index();
                $table->string('pickup_time', 30)->nullable();
                $table->string('pickup_address', 255)->nullable();
                
                // 2. Schedule Delivery fields
                $table->date('delivery_date')->nullable()->index();
                $table->string('delivery_time', 30)->nullable();
                $table->string('delivery_address', 255)->nullable();
                
                // 3. Assign Delivery Staff fields
                $table->unsignedBigInteger('delivery_staff_id')->nullable()->index();
                $table->string('delivery_staff_name', 100)->nullable();
                
                // 4. Track Pickup & Delivery Status & 5. Delivery History
                // Stages: Scheduled -> Picked Up -> In Transit -> Delivered (also Pending, Assigned)
                $table->string('status', 50)->default('Scheduled')->index();
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
        Schema::dropIfExists('pickup_deliveries');
    }
};
