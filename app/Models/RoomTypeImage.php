<?php

namespace App\Models;

use App\Services\ImageService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class RoomTypeImage extends Model
{
    protected $fillable = [
        'room_type_id',
        'image_path',
        'caption',
        'display_order'
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image_path && Storage::disk('public')->exists($this->image_path)) {
            return asset('storage/' . $this->image_path);
        }

        return app(ImageService::class)->getDefaultImageUrl();
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($image) {
            if ($image->image_path) {
                Storage::disk('public')->delete($image->image_path);
            }
        });
    }
}
