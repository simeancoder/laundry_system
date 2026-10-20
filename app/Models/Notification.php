<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'type',
        'title',
        'message',
        'target',
        'scheduled_date',
        'status',
    ];

    /**
     * Get badge background class by status.
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'Sent' => 'bg-emerald-50 text-emerald-600',
            'Pending' => 'bg-amber-50 text-amber-600',
            'Scheduled' => 'bg-blue-50 text-blue-600',
            'Failed' => 'bg-rose-50 text-rose-600',
            default => 'bg-gray-100 text-gray-600',
        };
    }
}
