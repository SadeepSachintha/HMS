<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        \App\Models\Reservation::observe(\App\Observers\ReservationObserver::class);
        \App\Models\Payment::observe(\App\Observers\PaymentObserver::class);

        Event::listen(\Illuminate\Auth\Events\Login::class, function ($event) {
            \App\Models\ActivityLog::create([
                'user_id' => $event->user->id,
                'action' => 'login',
                'description' => "User {$event->user->name} logged in successfully.",
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });

        Event::listen(\Illuminate\Auth\Events\Logout::class, function ($event) {
            if ($event->user) {
                \App\Models\ActivityLog::create([
                    'user_id' => $event->user->id,
                    'action' => 'logout',
                    'description' => "User {$event->user->name} logged out.",
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
            }
        });

        Event::listen(\Illuminate\Auth\Events\Failed::class, function ($event) {
            \App\Models\ActivityLog::create([
                'user_id' => $event->user ? $event->user->id : null,
                'action' => 'failed_login',
                'description' => "Failed login attempt for email: " . ($event->credentials['email'] ?? 'unknown'),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });
    }
}
