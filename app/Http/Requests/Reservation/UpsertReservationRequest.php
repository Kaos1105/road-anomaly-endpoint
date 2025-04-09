<?php

namespace App\Http\Requests\Reservation;


use App\Http\Requests\TimestampRequest;
use App\Models\Reservation;
use Illuminate\Validation\Rule;

class UpsertReservationRequest extends TimestampRequest
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
        $timeRules = ['bail', 'required', 'date_format:H:i'];
        $timeRule = [
            'start_time' => [...$timeRules, 'before_or_equal:end_time'],
            'end_time' => [...$timeRules, 'after_or_equal:start_time']
        ];
        return [
            ...parent::rules(),
            'facility_id' => ['required', 'numeric', Rule::exists('facility_facilities', 'id')],
            'reservation_date' => 'required|date',
            ...$timeRule,
            'work_contents' => 'required|string|max:50',
            'use_person_id' => ['required', 'numeric', Rule::exists('organization_employees', 'id')],
            'regis_time_schedule' => 'required|boolean'
        ];

    }

    public function attributes(): array
    {
        return [
            'facility_id' => __('attributes.reservation.facility_id'),
            'reservation_date' => __('attributes.reservation.reservation_date'),
            'start_time' => __('attributes.reservation.start_time'),
            'end_time' => __('attributes.reservation.end_time'),
            'work_contents' => __('attributes.reservation.work_contents'),
            'use_person_id' => __('attributes.reservation.use_person_id'),
            'regis_time_schedule' => __('attributes.reservation.regis_time_schedule'),
        ];
    }
}
