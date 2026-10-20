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
        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->id();
                $table->string('type')->default('Order Ready');
                $table->string('title')->default('Order Ready');
                $table->text('message');
                $table->string('target')->default('All Customers');
                $table->string('scheduled_date')->nullable();
                $table->enum('status', ['Sent', 'Pending', 'Scheduled', 'Failed'])->default('Sent');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
