<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_time',
        'end_time',
        'location',
        'location_id',
        'max_attendees',
        'price',
        'customer_id',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Get the customer that owns the event.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the staff members assigned to the event.
     */
    public function staff()
    {
        return $this->belongsToMany(Staff::class)
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Get the location assigned to the event.
     */
    public function location_rel()
    {
        return $this->belongsTo(EventLocation::class, 'location_id');
    }
}
