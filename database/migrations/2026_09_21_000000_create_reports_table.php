<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('reports')) {
            Schema::create('reports', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('category', 100)->default('daily_sale');
                $table->string('type', 100)->default('Status');
                $table->string('date', 50)->default('01/Jan/25');
                $table->string('generated_by', 100)->default('Admin');
                $table->string('generated_on', 100)->default('01/Jan/25 10:00 AM');
                $table->text('description')->nullable();
                $table->longText('details')->nullable();
                $table->string('status', 50)->default('Completed');
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
        Schema::dropIfExists('reports');
    }
}
