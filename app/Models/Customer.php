<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'loyalty_points',
        'notes'
    ];

    /**
     * Get the reservations for the customer.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
