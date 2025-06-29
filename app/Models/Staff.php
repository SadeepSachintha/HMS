<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'position',
        'department',
        'phone',
        'emergency_contact',
        'hire_date',
        'salary',
        'status',
    ];

    protected $casts = [
        'hire_date' => 'date',
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
        return $this->belongsToMany(Event::class)
            ->withPivot('role')
            ->withTimestamps();
    }
}