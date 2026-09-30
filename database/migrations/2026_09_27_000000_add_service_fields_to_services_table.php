<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceFieldsToServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('services')) {
            Schema::table('services', function (Blueprint $table) {
                if (!Schema::hasColumn('services', 'name') && !Schema::hasColumn('services', 'service_name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::hasColumn('services', 'service_name')) {
                    $table->string('service_name')->nullable();
                }
                if (!Schema::hasColumn('services', 'service_type')) {
                    $table->string('service_type')->nullable();
                }
                if (!Schema::hasColumn('services', 'price_per_kg')) {
                    $table->decimal('price_per_kg', 8, 2)->nullable();
                }
                if (!Schema::hasColumn('services', 'price_per_item')) {
                    $table->decimal('price_per_item', 8, 2)->nullable();
                }
                if (!Schema::hasColumn('services', 'estimated_time')) {
                    $table->string('estimated_time')->nullable();
                }
                if (!Schema::hasColumn('services', 'estimated_completion_hrs')) {
                    $table->integer('estimated_completion_hrs')->nullable();
                }
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
        if (Schema::hasTable('services')) {
            Schema::table('services', function (Blueprint $table) {
                $columns = ['service_name', 'service_type', 'price_per_kg', 'price_per_item', 'estimated_time', 'estimated_completion_hrs'];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('services', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
}
