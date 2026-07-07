<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

/**
 * Class SettingsController
 * 
 * Handles the storage, display, and retrieval of global application configurations and settings,
 * such as hotel names, contact info, check-in/out times, and notification preferences.
 * 
 * @package App\Http\Controllers
 */
class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     * Requires authentication middleware for all endpoints.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the application settings configuration page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $settings = Setting::first();
        return view('settings.index', compact('settings'));
    }

    /**
     * Update the global system settings in storage.
     * Creates a new setting entry if none exists.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'hotel_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:20',
            'check_in_time' => 'required',
            'check_out_time' => 'required',
        ]);

        $settings = Setting::first();
        // If settings record doesn't exist, instantiate a new one
        if (!$settings) {
            $settings = new Setting();
        }

        $settings->hotel_name = $request->hotel_name;
        $settings->contact_email = $request->contact_email;
        $settings->contact_phone = $request->contact_phone;
        $settings->check_in_time = $request->check_in_time;
        $settings->check_out_time = $request->check_out_time;
        $settings->email_notifications = $request->has('email_notifications');
        $settings->sms_notifications = $request->has('sms_notifications');
        $settings->save();

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }
}
