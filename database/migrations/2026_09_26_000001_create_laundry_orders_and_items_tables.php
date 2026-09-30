<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->string('order_number', 50)->unique();
                $table->unsignedBigInteger('customer_id')->nullable();
                $table->string('customer_name', 150);
                $table->string('customer_phone', 50)->nullable();
                $table->string('customer_email', 150)->nullable();
                $table->string('customer_address', 255)->nullable();
                $table->string('service_type', 100);
                $table->decimal('weight', 8, 2)->default(0.00);
                $table->integer('items_count')->default(1);
                $table->dateTime('order_date');
                $table->date('pickup_date')->nullable();
                $table->date('delivery_date')->nullable();
                $table->decimal('total_price', 10, 2)->default(0.00);
                $table->string('status', 50)->default('Received'); 
                // Received, Washing, Drying, Ironing, Ready for Pickup, Out for Delivery, Completed, Cancelled
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->index('order_number');
                $table->index('status');
                $table->index('order_date');
            });
        }

        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('order_id');
                $table->string('service_name', 150);
                $table->string('quantity', 50)->default('1.0 kg');
                $table->decimal('unit_price', 10, 2)->default(0.00);
                $table->decimal('subtotal', 10, 2)->default(0.00);
                $table->timestamps();

                $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
