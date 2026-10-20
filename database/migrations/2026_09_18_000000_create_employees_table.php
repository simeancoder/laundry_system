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
        if (!Schema::hasTable('employees')) {
            Schema::create('employees', function (Blueprint $table) {
                $table->id();
                $table->string('employee_id')->unique();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('role');
                $table->string('phone');
                $table->string('address')->nullable();
                $table->string('password')->nullable();
                $table->string('status')->default('Active');
                $table->string('work_schedule')->default('Full Time (08:00 AM - 05:00 PM)');
                $table->text('job_role_details')->nullable();
                $table->string('avatar')->nullable();
                $table->string('attendance_status')->default('Present');
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
        Schema::dropIfExists('employees');
    }
};
