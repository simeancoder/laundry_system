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
        if (!Schema::hasTable('machines')) {
            Schema::create('machines', function (Blueprint $table) {
                $table->id();
                $table->string('machine_id', 50)->unique();
                $table->string('name');
                $table->string('type', 100);
                $table->string('capacity', 50)->nullable()->default('-');
                $table->string('model', 100)->nullable();
                $table->string('location', 100)->nullable()->default('Laundry Room 1');
                $table->enum('status', ['Available', 'In Use', 'Under Maintenance'])->default('Available');
                $table->string('last_maintenance', 50)->nullable();
                $table->string('next_maintenance', 50)->nullable();
                $table->json('maintenance_history')->nullable();
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
        Schema::dropIfExists('machines');
    }
};
