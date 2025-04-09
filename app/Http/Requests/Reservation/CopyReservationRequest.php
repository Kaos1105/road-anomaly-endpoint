<?php

namespace App\Http\Requests\Reservation;

use App\Http\Requests\TimestampRequest;
use App\Models\Reservation;
use Illuminate\Validation\Rule;

class CopyReservationRequest extends TimestampRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reservation_date' => 'required|date',
        ];

    }

    public function attributes(): array
    {
        return [
        ];
    }
}
