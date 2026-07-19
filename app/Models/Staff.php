<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;


class Staff extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'position',
        'department',
        'address',
        'emergency_contact',
        'hire_date',
        'salary',
        'status',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'salary' => 'decimal:2',
    ];

    /**
     * Get the user that owns the staff.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the events for the staff.
     */
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_staff')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Scope a query to only include active staff.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive staff.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope a query to only include staff on leave.
     */
    public function scopeOnLeave($query)
    {
        return $query->where('status', 'on_leave');
    }
}
