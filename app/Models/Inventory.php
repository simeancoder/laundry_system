<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories';

    protected $fillable = [
        'name',
        'category',
        'stock',
        'unit',
        'status',
        'min_stock',
        'notes',
        'supplier',
        'unit_price',
        'last_restocked',
    ];

    protected $casts = [
        'stock' => 'integer',
        'min_stock' => 'integer',
        'unit_price' => 'decimal:2',
    ];

    /**
     * Helper to auto-evaluate and update status based on stock level.
     */
    public function updateStatusBasedOnStock()
    {
        $min = $this->min_stock ?: 15;
        if ($this->stock <= 0) {
            $this->status = 'Out of Stock';
        } elseif ($this->stock <= $min) {
            $this->status = 'Low Stock';
        } else {
            $this->status = 'In Stock';
        }
        $this->save();
        return $this->status;
    }
}
