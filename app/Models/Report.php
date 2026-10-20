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
        'type',
        'date_range',
        'generated_by',
        'generated_on',
        'status',
        'category',
        'description',
        'details',
    ];

    /**
     * Pill badge color by type.
     */
    public function getTypeBadgeAttribute(): string
    {
        return match (strtolower($this->type)) {
            'sales' => 'bg-emerald-50 text-emerald-600',
            'order' => 'bg-blue-50 text-blue-600',
            'payment' => 'bg-teal-50 text-teal-600',
            'inventory' => 'bg-amber-50 text-amber-600',
            'employee', 'staff' => 'bg-indigo-50 text-indigo-600',
            'machine' => 'bg-sky-50 text-sky-600',
            'delivery' => 'bg-green-50 text-green-600',
            'service' => 'bg-rose-50 text-rose-600',
            default => 'bg-gray-100 text-gray-700',
        };
    }
}
