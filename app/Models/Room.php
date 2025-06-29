<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'room_type_id',
        'floor',
        'status',
        'is_clean',
        'notes'
    ];

    protected $casts = [
        'is_clean' => 'boolean',
    ];

    /**
     * Get the room type that owns the room.
     */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * Get the reservations for the room.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
