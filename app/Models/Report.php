<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';

    protected $fillable = [
        'name',
        'category',
        'type',
        'date',
        'generated_by',
        'generated_on',
        'description',
        'details',
        'status',
    ];
}
