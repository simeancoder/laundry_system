<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Service extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'services';

    /**
     * Primary key. In original schema it was 'service_id'.
     */
    protected $primaryKey = 'service_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     */
    public $incrementing = true;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'name',
        'service_name',
        'service_type',
        'price',
        'price_per_kg',
        'price_per_item',
        'estimated_time',
        'estimated_completion_hrs',
        'description',
        'image',
        'icon',
        'status',
    ];

    /**
     * Get the primary key for the model dynamically.
     */
    public function getKeyName()
    {
        try {
            if (Schema::hasColumn('services', 'service_id')) {
                return 'service_id';
            }
            if (Schema::hasColumn('services', 'id')) {
                return 'id';
            }
        } catch (\Throwable $e) {
            // fallback
        }
        return $this->primaryKey ?? 'service_id';
    }

    /**
     * Accessor for id.
     */
    public function getIdAttribute()
    {
        return $this->attributes['id'] ?? $this->attributes['service_id'] ?? null;
    }

    /**
     * Accessor for service_id.
     */
    public function getServiceIdAttribute()
    {
        return $this->attributes['service_id'] ?? $this->attributes['id'] ?? null;
    }

    /**
     * Accessor for name / service_name.
     */
    public function getNameAttribute()
    {
        return $this->attributes['name'] ?? ($this->attributes['service_name'] ?? 'Service');
    }

    public function getServiceNameAttribute()
    {
        return $this->attributes['service_name'] ?? ($this->attributes['name'] ?? 'Service');
    }

    /**
     * Accessor for service_type.
     */
    public function getServiceTypeAttribute()
    {
        return $this->attributes['service_type'] ?? ($this->attributes['name'] ?? ($this->attributes['service_name'] ?? 'Wash Only'));
    }

    /**
     * Accessor for price_per_kg / price.
     */
    public function getPricePerKgAttribute()
    {
        return $this->attributes['price_per_kg'] ?? ($this->attributes['price'] ?? 1.50);
    }

    /**
     * Accessor for estimated_time.
     */
    public function getEstimatedTimeAttribute()
    {
        if (!empty($this->attributes['estimated_time'])) {
            return $this->attributes['estimated_time'];
        }
        if (!empty($this->attributes['estimated_completion_hrs'])) {
            $hrs = (int)$this->attributes['estimated_completion_hrs'];
            if ($hrs <= 6) return 'Same day';
            if ($hrs <= 24) return '1–2 days';
            if ($hrs <= 48) return '2–3 days';
            return '3–5 days';
        }
        return '1–2 days';
    }
}