<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email',
            'phone' => ['required', 'regex:/^\+(?:[0-9] ?){6,14}[0-9]$/'],
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'loyalty_points' => 'nullable|integer|min:0',
            'notes' => 'nullable|string'
        ];
    }

    public function messages()
    {
        return [
            'phone.regex' => 'Please enter a valid phone number with country code (e.g., +1234567890)'
        ];
    }
}
