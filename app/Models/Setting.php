<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_name',
        'contact_email',
        'contact_phone',
        'check_in_time',
        'check_out_time',
        'email_notifications',
        'sms_notifications',
    ];

    protected $casts = [
        'email_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
    ];
}
