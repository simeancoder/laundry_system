<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'name',
        'email',
        'role',
        'phone',
        'address',
        'password',
        'status',
        'work_schedule',
        'job_role_details',
        'avatar',
        'attendance_status',
    ];

    protected $hidden = [
        'password',
    ];
}
