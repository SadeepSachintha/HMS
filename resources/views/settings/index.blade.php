@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-cogs me-2 text-gold"></i>System Configurations & Taxes</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="POST" novalidate>
                        @csrf

                        <h5 class="text-primary mb-3"><i class="fas fa-hotel me-2"></i>Hotel Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="hotel_name" class="form-label">Hotel Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('hotel_name') is-invalid @enderror" id="hotel_name" name="hotel_name" value="{{ old('hotel_name', $settings->hotel_name ?? '') }}" required>
                                @error('hotel_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="check_in_time" class="form-label">Default Check-in Time <span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('check_in_time') is-invalid @enderror" id="check_in_time" name="check_in_time" value="{{ old('check_in_time', $settings->check_in_time ?? '14:00') }}" required>
                                @error('check_in_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="check_out_time" class="form-label">Default Check-out Time <span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('check_out_time') is-invalid @enderror" id="check_out_time" name="check_out_time" value="{{ old('check_out_time', $settings->check_out_time ?? '12:00') }}" required>
                                @error('check_out_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="contact_email" class="form-label">Contact Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('contact_email') is-invalid @enderror" id="contact_email" name="contact_email" value="{{ old('contact_email', $settings->contact_email ?? '') }}" required>
                                @error('contact_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contact_phone" class="form-label">Contact Phone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $settings->contact_phone ?? '') }}" required>
                                @error('contact_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="text-primary mb-3"><i class="fas fa-percent me-2"></i>Taxes, Levies & Service Charges</h5>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="service_charge_rate" class="form-label">Service Charge (%) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0" max="100" class="form-control @error('service_charge_rate') is-invalid @enderror" id="service_charge_rate" name="service_charge_rate" value="{{ old('service_charge_rate', $settings->service_charge_rate ?? 10.00) }}" required>
                                <div class="form-text text-muted">Applied to raw room & food subtotals.</div>
                                @error('service_charge_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="sscl_rate" class="form-label">SSCL (%) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0" max="100" class="form-control @error('sscl_rate') is-invalid @enderror" id="sscl_rate" name="sscl_rate" value="{{ old('sscl_rate', $settings->sscl_rate ?? 2.50) }}" required>
                                <div class="form-text text-muted">Social Security Contribution Levy.</div>
                                @error('sscl_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="tdl_rate" class="form-label">TDL (%) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0" max="100" class="form-control @error('tdl_rate') is-invalid @enderror" id="tdl_rate" name="tdl_rate" value="{{ old('tdl_rate', $settings->tdl_rate ?? 1.00) }}" required>
                                <div class="form-text text-muted">Tourism Development Levy.</div>
                                @error('tdl_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="vat_rate" class="form-label">VAT (%) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0" max="100" class="form-control @error('vat_rate') is-invalid @enderror" id="vat_rate" name="vat_rate" value="{{ old('vat_rate', $settings->vat_rate ?? 18.00) }}" required>
                                <div class="form-text text-muted">Value Added Tax.</div>
                                @error('vat_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- <hr class="my-4">

                        <h5 class="text-primary mb-3"><i class="fas fa-bell me-2"></i>Notifications</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" id="email_notifications" name="email_notifications" value="1" {{ old('email_notifications', $settings->email_notifications ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="email_notifications">Enable Email Notifications</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" id="sms_notifications" name="sms_notifications" value="1" {{ old('sms_notifications', $settings->sms_notifications ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="sms_notifications">Enable SMS Notifications</label>
                                </div>
                            </div>
                        </div> -->

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-1"></i>Save Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
