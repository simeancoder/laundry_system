<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'order_number',
        'customer_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_address',
        'service_type',
        'weight',
        'items_count',
        'order_date',
        'pickup_date',
        'delivery_date',
        'total_price',
        'status',
        'notes',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'items_count' => 'integer',
        'total_price' => 'decimal:2',
        'order_date' => 'datetime',
        'pickup_date' => 'date',
        'delivery_date' => 'date',
    ];

    /**
     * Relationship: An order has many order items.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    /**
     * Relationship: An order optionally belongs to a customer.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Scope: Search orders by order number, customer name, phone, or service type.
     */
    public function scopeSearch($query, $term)
    {
        if (empty($term)) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('order_number', 'LIKE', "%{$term}%")
              ->orWhere('customer_name', 'LIKE', "%{$term}%")
              ->orWhere('customer_phone', 'LIKE', "%{$term}%")
              ->orWhere('customer_email', 'LIKE', "%{$term}%")
              ->orWhere('service_type', 'LIKE', "%{$term}%");
        });
    }

    /**
     * Scope: Filter by status.
     */
    public function scopeFilterStatus($query, $status)
    {
        if (!empty($status) && $status !== 'All' && $status !== 'All Status') {
            return $query->where('status', $status);
        }
        return $query;
    }

    /**
     * Scope: Filter by service type.
     */
    public function scopeFilterServiceType($query, $type)
    {
        if (!empty($type) && $type !== 'All' && $type !== 'All Service Types') {
            return $query->where('service_type', $type);
        }
        return $query;
    }

    /**
     * Scope: Filter by date range.
     */
    public function scopeDateRange($query, $from, $to)
    {
        if (!empty($from)) {
            $query->whereDate('order_date', '>=', $from);
        }
        if (!empty($to)) {
            $query->whereDate('order_date', '<=', $to);
        }
        return $query;
    }
}
