<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting
 * 
 * Represents the global system/hotel configuration options.
 * 
 * @property int $id
 * @property string $hotel_name
 * @property string $contact_email
 * @property string $contact_phone
 * @property string $check_in_time
 * @property string $check_out_time
 * @property bool $email_notifications
 * @property bool $sms_notifications
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @package App\Models
 */
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
        'service_charge_rate',
        'sscl_rate',
        'tdl_rate',
        'vat_rate',
    ];

    protected $casts = [
        'email_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
        'service_charge_rate' => 'float',
        'sscl_rate' => 'float',
        'tdl_rate' => 'float',
        'vat_rate' => 'float',
    ];
}
