<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\LogsActivity;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $contact_number
 * @property string|null $address
 * @property string $role
 * @property string $password
 * @property bool $status
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SystemNotification[] $systemNotifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Alert[] $alerts
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, LogsActivity;

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
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function systemNotifications()
    {
        return $this->hasMany(SystemNotification::class);
    }

    /**
     * Get the unread system notifications for the user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function unreadSystemNotifications()
    {
        return $this->systemNotifications()->where('is_read', false);
    }

    /**
     * Get the alerts for the user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    /**
     * Get the unread alerts for the user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function unreadAlerts()
    {
        return $this->alerts()->where('is_read', false);
    }

    /**
     * Check if the user has an admin role.
     * 
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user has a manager role.
     * 
     * @return bool
     */
    public function isManager()
    {
        return $this->role === 'manager';
    }

    /**
     * Check if the user has a staff role.
     * 
     * @return bool
     */
    public function isStaff()
    {
        return $this->role === 'staff';
    }

    /**
     * Check if the user has a guest role.
     * 
     * @return bool
     */
    public function isGuest()
    {
        return $this->role === 'guest';
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }
}
