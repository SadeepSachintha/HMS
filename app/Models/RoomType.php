<?php

namespace App\Models;

use App\Services\ImageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price_per_night',
        'capacity',
        'amenities'
    ];

    protected $casts = [
        'amenities' => 'array'
    ];

    /**
     * Get the rooms for the room type.
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function images()
    {
        return $this->hasMany(RoomTypeImage::class)->orderBy('display_order');
    }

    public function getMainImageUrlAttribute()
    {
        $mainImage = $this->images()->first();
        return $mainImage ? $mainImage->image_url : app(ImageService::class)->getDefaultImageUrl();
    }

    public function getAllImagesAttribute()
    {
        $images = $this->images;
        if ($images->isEmpty()) {
            return collect([
                (object)[
                    'image_url' => app(ImageService::class)->getDefaultImageUrl(),
                    'caption' => 'No Image Available',
                    'display_order' => 0
                ]
            ]);
        }
        return $images;
    }
}
