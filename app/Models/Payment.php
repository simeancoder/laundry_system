<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'payment_id',
        'order_number',
        'customer_name',
        'customer_initials',
        'avatar_color',
        'amount',
        'payment_method',
        'status',
        'payment_date',
        'reference_no',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'datetime',
    ];

    /**
     * Relationship: A payment optionally belongs to an order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_number', 'order_number');
    }

    /**
     * Scope: Filter by status.
     */
    public function scopeStatus($query, $status)
    {
        if (!empty($status) && $status !== 'All') {
            return $query->where('status', strtoupper($status));
        }
        return $query;
    }

    /**
     * Scope: Filter by payment method.
     */
    public function scopeMethod($query, $method)
    {
        if (!empty($method) && $method !== 'All') {
            return $query->where('payment_method', $method);
        }
        return $query;
    }

    /**
     * Scope: Search by keyword.
     */
    public function scopeSearch($query, $term)
    {
        if (empty($term)) {
            return $query;
        }

        $term = trim($term);
        return $query->where(function ($q) use ($term) {
            $q->where('payment_id', 'LIKE', "%{$term}%")
              ->orWhere('order_number', 'LIKE', "%{$term}%")
              ->orWhere('customer_name', 'LIKE', "%{$term}%")
              ->orWhere('reference_no', 'LIKE', "%{$term}%");
        });
    }
}
