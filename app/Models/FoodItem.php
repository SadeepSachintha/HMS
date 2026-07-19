<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;


class FoodItem extends Model
{
    use HasFactory, LogsActivity;

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
}