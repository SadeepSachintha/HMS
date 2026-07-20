<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
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
                    if ($room && $room->roomType) {
                        $name = $room->roomType->name;
                        $maxCapacity = $room->roomType->capacity;

                        if (strcasecmp($name, 'Single Room') === 0) {
                            $maxCapacity = 1;
                        } elseif (strcasecmp($name, 'Double Room') === 0) {
                            $maxCapacity = 2;
                        } elseif (strcasecmp($name, 'Deluxe Family Room') === 0) {
                            $maxCapacity = 4;
                        }

                        if ($value > $maxCapacity) {
                            $fail('The number of guests exceeds the maximum allowed for ' . $name . ' (max: ' . $maxCapacity . ').');
                        }
                    }
                },
            ],
            'status' => 'required|in:pending,confirmed,checked_in,checked_out,cancelled'
        ];
    }
}
