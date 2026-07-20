<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Reservation;

class AutoCheckOutMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Only run for authenticated users to avoid running on public website pages
        if (auth()->check()) {
            $settings = \App\Models\Setting::first();
            $checkOutTime = $settings->check_out_time ?? '12:00:00';
            $currentTime = now()->toTimeString();

            // Find all checked-in reservations whose checkout date has passed or is today
            $reservations = Reservation::where('status', 'checked_in')
                ->whereDate('check_out_date', '<=', now()->toDateString())
                ->get();

            foreach ($reservations as $reservation) {
                // If checkout date is today, only check out if the current time is past checkOutTime
                if ($reservation->check_out_date->toDateString() === now()->toDateString()) {
                    if ($currentTime < $checkOutTime) {
                        continue;
                    }
                }

                // If the invoice is paid, check it out
                if ($reservation->invoice && $reservation->invoice->status === 'paid') {
                    $reservation->update(['status' => 'checked_out']);
                }
            }
        }

        return $next($request);
    }
}
