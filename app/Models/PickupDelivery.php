<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupDelivery extends Model
{
    use HasFactory;

    protected $table = 'pickup_deliveries';

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_phone',
        'service_type',
        'total_amount',
        'pickup_date',
        'pickup_time',
        'pickup_address',
        'delivery_date',
        'delivery_time',
        'delivery_address',
        'delivery_staff_id',
        'delivery_staff_name',
        'status',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'pickup_date' => 'date',
        'delivery_date' => 'date',
    ];

    /**
     * Get the formatted pickup date and time string.
     */
    public function getPickupDateTimeFormattedAttribute(): string
    {
        $dateStr = $this->pickup_date ? $this->pickup_date->format('Y-m-d') : '';
        $timeStr = $this->pickup_time ?? '';
        return trim("{$dateStr} {$timeStr}");
    }

    /**
     * Get the formatted delivery date and time string.
     */
    public function getDeliveryDateTimeFormattedAttribute(): string
    {
        $dateStr = $this->delivery_date ? $this->delivery_date->format('Y-m-d') : '';
        $timeStr = $this->delivery_time ?? '';
        return trim("{$dateStr} {$timeStr}");
    }

    /**
     * Status styling helper for Tailwind badges.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match (strtolower(trim($this->status))) {
            'scheduled' => 'bg-[#E0F2FE] text-[#0284C7]', // Blue
            'assigned' => 'bg-[#FEF3C7] text-[#D97706]', // Amber / Orange
            'in transit', 'picked up' => 'bg-[#F3E8FF] text-[#9333EA]', // Purple
            'pending' => 'bg-[#FEE2E2] text-[#DC2626]', // Red
            'delivered', 'completed' => 'bg-[#DCFCE7] text-[#16A34A]', // Green
            default => 'bg-gray-100 text-gray-700',
        };
    }

    /**
     * Scope: Filter by tab:
     * - 'pickups': Scheduled Pickups
     * - 'deliveries': Scheduled Deliveries
     * - 'in_progress': In Progress (Assigned, In Transit, Picked Up)
     * - 'history': History (Delivered, Completed)
     */
    public function scopeTab($query, ?string $tab)
    {
        if (empty($tab) || $tab === 'pickups') {
            return $query->whereIn('status', ['Scheduled', 'Pending']);
        }
        if ($tab === 'deliveries') {
            return $query->whereIn('status', ['Scheduled', 'Assigned', 'In Transit']);
        }
        if ($tab === 'in_progress') {
            return $query->whereIn('status', ['In Transit', 'Picked Up', 'Assigned']);
        }
        if ($tab === 'history') {
            return $query->whereIn('status', ['Delivered', 'Completed']);
        }
        return $query;
    }

    /**
     * Scope: Filter by Status dropdown.
     */
    public function scopeStatusFilter($query, ?string $status)
    {
        if (!empty($status) && $status !== 'All' && $status !== 'All Status') {
            return $query->where('status', $status);
        }
        return $query;
    }

    /**
     * Scope: Filter by Date dropdown.
     */
    public function scopeDateFilter($query, ?string $dateFilter)
    {
        if (empty($dateFilter) || $dateFilter === 'All' || $dateFilter === 'Date') {
            return $query;
        }

        if ($dateFilter === 'Today') {
            return $query->where(function ($q) {
                $q->whereDate('pickup_date', today())
                  ->orWhereDate('delivery_date', today());
            });
        }

        if ($dateFilter === 'This Week') {
            return $query->where(function ($q) {
                $q->whereBetween('pickup_date', [now()->startOfWeek(), now()->endOfWeek()])
                  ->orWhereBetween('delivery_date', [now()->startOfWeek(), now()->endOfWeek()]);
            });
        }

        if ($dateFilter === 'This Month') {
            return $query->where(function ($q) {
                $q->whereMonth('pickup_date', now()->month)
                  ->orWhereMonth('delivery_date', now()->month);
            });
        }

        return $query;
    }

    /**
     * Scope: Search by order number, customer name, or phone.
     */
    public function scopeSearch($query, ?string $search)
    {
        if (empty($search)) {
            return $query;
        }

        $term = trim($search);
        return $query->where(function ($q) use ($term) {
            $q->where('order_number', 'LIKE', "%{$term}%")
              ->orWhere('customer_name', 'LIKE', "%{$term}%")
              ->orWhere('customer_phone', 'LIKE', "%{$term}%")
              ->orWhere('service_type', 'LIKE', "%{$term}%")
              ->orWhere('delivery_staff_name', 'LIKE', "%{$term}%");
        });
    }
}
