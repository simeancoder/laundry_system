<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    protected $table = 'machines';

    protected $fillable = [
        'machine_id',
        'name',
        'type',
        'capacity',
        'model',
        'location',
        'status',
        'last_maintenance',
        'next_maintenance',
        'maintenance_history',
        'notes',
    ];

    protected $casts = [
        'maintenance_history' => 'array',
    ];

    /**
     * Default status badge styling helper
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'Available' => 'bg-[#DCFCE7] text-[#16A34A] border border-emerald-200/50',
            'In Use' => 'bg-[#FEF3C7] text-[#D97706] border border-amber-200/50',
            'Under Maintenance' => 'bg-[#FEE2E2] text-[#DC2626] border border-rose-200/50',
            default => 'bg-gray-100 text-gray-700',
        };
    }
}
