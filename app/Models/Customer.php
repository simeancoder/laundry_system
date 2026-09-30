<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'customer_id',
        'name',
        'phone',
        'email',
        'address',
        'tier',
        'status',
        'avatar',
        'registration_date',
    ];

    protected $casts = [
        'registration_date' => 'date',
    ];

    /**
     * Relationship: A customer has many orders.
     */
    public function orders()
    {
        return $this->hasMany(CustomerOrder::class, 'customer_id')->orderBy('order_date', 'desc');
    }

    /**
     * Scope for searching customers.
     */
    public function scopeSearch($query, $search)
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('customer_id', 'LIKE', "%{$search}%")
              ->orWhere('name', 'LIKE', "%{$search}%")
              ->orWhere('phone', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%")
              ->orWhere('address', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Scope for filtering by tier or status.
     */
    public function scopeFilter($query, $filter)
    {
        if (empty($filter) || $filter === 'All' || $filter === 'All Customers') {
            return $query;
        }

        if (in_array(strtoupper($filter), ['GOLD', 'SILVER', 'BRONZE', 'REGULAR'])) {
            return $query->where('tier', strtoupper($filter));
        }

        if (in_array(ucfirst(strtolower($filter)), ['Active', 'Inactive'])) {
            return $query->where('status', ucfirst(strtolower($filter)));
        }

        return $query;
    }
}
