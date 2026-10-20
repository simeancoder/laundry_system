<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $table = 'promotions';

    protected $fillable = [
        'name',
        'type',
        'discount_value',
        'discount_unit',
        'start_date',
        'end_date',
        'coupon_code',
        'description',
        'status',
    ];

    /**
     * Formatted discount display e.g. "20% OFF" or "$5.00 OFF"
     */
    public function getFormattedDiscountAttribute(): string
    {
        if ($this->discount_unit === '$') {
            return '$' . number_format((float)$this->discount_value, 2) . ' OFF';
        }
        return rtrim(rtrim((string)$this->discount_value, '0'), '.') . '% OFF';
    }

    /**
     * Formatted period display e.g. "2025-09-01 → 2025-09-30"
     */
    public function getFormattedPeriodAttribute(): string
    {
        return ($this->start_date ?? '-') . ' → ' . ($this->end_date ?? '-');
    }
}
