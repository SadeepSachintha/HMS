<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'price',
        'is_available',
        'image_path',
        'ingredients',
    ];

    protected $casts = [
        'ingredients' => 'array',
    ];

    /**
     * Get the order items for the food item.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}