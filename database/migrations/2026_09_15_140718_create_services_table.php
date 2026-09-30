<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('services')) {
            Schema::create('services', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('service_type')->nullable();
                $table->decimal('price', 8, 2)->default(0);
                $table->decimal('price_per_kg', 8, 2)->nullable();
                $table->decimal('price_per_item', 8, 2)->nullable();
                $table->string('estimated_time')->nullable();
                $table->integer('estimated_completion_hrs')->nullable();
                $table->text('description')->nullable();
                $table->string('image')->nullable();
                $table->string('status')->default('Active'); // Active / Inactive
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
        Schema::dropIfExists('services');
    }
}
