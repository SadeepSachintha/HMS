<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;


/**
 * App\Models\Reservation
 *
 * @property int $id
 * @property int $customer_id
 * @property int $room_id
 * @property \Illuminate\Support\Carbon $check_in_date
 * @property \Illuminate\Support\Carbon $check_out_date
 * @property int $number_of_guests
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Customer $customer
 * @property-read \App\Models\Room $room
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment[] $payments
 * @property-read \App\Models\Invoice|null $invoice
 * @property-read float $total_price
 * @property-read float $total_paid
 */
class Reservation extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'number_of_guests',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'check_in_date' => 'datetime',
        'check_out_date' => 'datetime',
    ];

    /**
     * Get the customer that owns the reservation.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the room that owns the reservation.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the payments for the reservation.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the invoice for the reservation.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invoice()
    {
        return $this->hasOne(\App\Models\Invoice::class);
    }

    /**
     * Get the total price for the reservation (nights * room type price).
     * 
     * @return float
     */
    public function getTotalPriceAttribute()
    {
        if (!$this->room || !$this->room->roomType) return 0;
        $nights = 0;
        if ($this->check_in_date && $this->check_out_date) {
            $nights = $this->check_out_date->diffInDays($this->check_in_date);
        }
        return $nights * $this->room->roomType->price_per_night;
    }

    /**
     * Get the total paid for the reservation.
     * 
     * @return float
     */
    public function getTotalPaidAttribute()
    {
        return $this->payments()->sum('amount');
    }

    /**
     * Scope a query to only include unpaid or partially paid reservations.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnpaid($query)
    {
        return $query->where(function($q) {
            $q->whereDoesntHave('payments')
              ->orWhereRaw('(
                SELECT COALESCE(SUM(amount),0) FROM payments WHERE payments.reservation_id = reservations.id
              ) < (
                (DATEDIFF(check_out_date, check_in_date)) * (
                  SELECT price_per_night FROM room_types WHERE room_types.id = (
                    SELECT room_type_id FROM rooms WHERE rooms.id = reservations.room_id
                  )
                )
              )');
        });
    }
}
