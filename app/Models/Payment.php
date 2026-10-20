<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $primaryKey = 'payment_id';

    public $incrementing = true;

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
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
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $status
     * @return \Illuminate\Database\Eloquent\Builder
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
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $method
     * @return \Illuminate\Database\Eloquent\Builder
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
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $term
     * @return \Illuminate\Database\Eloquent\Builder
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
