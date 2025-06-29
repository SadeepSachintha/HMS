<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'number_of_guests',
        'status'
    ];

    protected $casts = [
        'check_in_date' => 'datetime',
        'check_out_date' => 'datetime',
    ];

    /**
     * Get the customer that owns the reservation.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the room that owns the reservation.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the payments for the reservation.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
