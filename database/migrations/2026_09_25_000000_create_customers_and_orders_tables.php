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
        if (!Schema::hasTable('customers')) {
            Schema::create('customers', function (Blueprint $table) {
                $table->id();
                $table->string('customer_id', 50)->unique();
                $table->string('name');
                $table->string('phone', 50);
                $table->string('email');
                $table->text('address');
                $table->string('tier', 50)->default('REGULAR'); // GOLD, SILVER, BRONZE, REGULAR
                $table->string('status', 50)->default('Active'); // Active, Inactive
                $table->string('avatar')->nullable();
                $table->date('registration_date');
                $table->timestamps();

                $table->index('phone');
                $table->index('email');
            });
        }

        if (!Schema::hasTable('customer_orders')) {
            Schema::create('customer_orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
                $table->string('order_number', 50);
                $table->string('service_type', 100);
                $table->string('status', 50)->default('Delivered');
                $table->date('order_date');
                $table->decimal('total_amount', 10, 2)->default(0.00);
                $table->timestamps();
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
        Schema::dropIfExists('customer_orders');
        Schema::dropIfExists('customers');
    }
};
