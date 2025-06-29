@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">System Settings</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <h5>General Settings</h5>
                            <hr>
                            <div class="mb-3">
                                <label for="hotel_name" class="form-label">Hotel Name</label>
                                <input type="text" class="form-control @error('hotel_name') is-invalid @enderror"
                                    id="hotel_name" name="hotel_name" value="{{ old('hotel_name', $settings->hotel_name ?? '') }}">
                                @error('hotel_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="contact_email" class="form-label">Contact Email</label>
                                <input type="email" class="form-control @error('contact_email') is-invalid @enderror"
                                    id="contact_email" name="contact_email" value="{{ old('contact_email', $settings->contact_email ?? '') }}">
                                @error('contact_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="contact_phone" class="form-label">Contact Phone</label>
                                <input type="text" class="form-control @error('contact_phone') is-invalid @enderror"
                                    id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $settings->contact_phone ?? '') }}">
                                @error('contact_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <h5>Booking Settings</h5>
                            <hr>
                            <div class="mb-3">
                                <label for="check_in_time" class="form-label">Default Check-in Time</label>
                                <input type="time" class="form-control @error('check_in_time') is-invalid @enderror"
                                    id="check_in_time" name="check_in_time" value="{{ old('check_in_time', $settings->check_in_time ?? '14:00') }}">
                                @error('check_in_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="check_out_time" class="form-label">Default Check-out Time</label>
                                <input type="time" class="form-control @error('check_out_time') is-invalid @enderror"
                                    id="check_out_time" name="check_out_time" value="{{ old('check_out_time', $settings->check_out_time ?? '11:00') }}">
                                @error('check_out_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <h5>Notification Settings</h5>
                            <hr>
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" id="email_notifications"
                                    name="email_notifications" {{ old('email_notifications', $settings->email_notifications ?? '') ? 'checked' : '' }}>
                                <label class="form-check-label" for="email_notifications">Enable Email Notifications</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="sms_notifications"
                                    name="sms_notifications" {{ old('sms_notifications', $settings->sms_notifications ?? '') ? 'checked' : '' }}>
                                <label class="form-check-label" for="sms_notifications">Enable SMS Notifications</label>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
