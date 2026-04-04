<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest extends FormRequest
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
            'customer_id' => 'required|exists:customers,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => [
                'required',
                'date',
                'after:check_in_date',
                function ($attribute, $value, $fail) {
                    $checkIn = strtotime($this->check_in_date);
                    $checkOut = strtotime($value);
                    if ($checkIn && $checkOut && ($checkOut - $checkIn) > 14 * 24 * 60 * 60) {
                        $fail('The reservation cannot exceed 14 days.');
                    }
                },
            ],
            'number_of_guests' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    $room = \App\Models\Room::with('roomType')->find($this->room_id);
                    if ($room && $room->roomType && $room->roomType->capacity) {
                        if ($value > $room->roomType->capacity) {
                            $fail('The number of guests exceeds the maximum allowed for this room type (max: ' . $room->roomType->capacity . ').');
                        }
                    }
                },
            ],
            'status' => 'required|in:pending,confirmed,checked_in,checked_out,cancelled'
        ];
    }
}
