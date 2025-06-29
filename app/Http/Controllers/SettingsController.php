<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $settings = Setting::first();
        return view('settings.index', compact('settings'));
    }

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
