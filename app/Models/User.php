<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'contact_number',
        'address',
        'role',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'boolean',
        'email_verified_at' => 'datetime',
        'role' => 'string',
    ];

    /**
     * Get the system notifications for the user.
     */
    public function systemNotifications()
    {
        return $this->hasMany(SystemNotification::class);
    }

    /**
     * Get the unread system notifications for the user.
     */
    public function unreadSystemNotifications()
    {
        return $this->systemNotifications()->where('is_read', false);
    }

    /**
     * Get the alerts for the user.
     */
    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    /**
     * Get the unread alerts for the user.
     */
    public function unreadAlerts()
    {
        return $this->alerts()->where('is_read', false);
    }

    // Add role helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isManager()
    {
        return $this->role === 'manager';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }
}
