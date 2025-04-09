<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperReservation
 */
class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'facility_id',
        'reservation_date',
        'start_time',
        'end_time',
        'work_contents',
        'use_person_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public static array $selectProps = [
        'facility_reservations.id',
        'facility_reservations.facility_id',
        'facility_reservations.reservation_date',
        'facility_reservations.start_time',
        'facility_reservations.end_time',
        'facility_reservations.work_contents',
        'facility_reservations.use_person_id',
        'facility_reservations.created_by',
        'facility_reservations.updated_by',
        'facility_reservations.created_at',
        'facility_reservations.updated_at',
    ];

    protected $table = 'facility_reservations';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
        'updated_at' => 'datetime:Y-m-d H:m',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'updated_by');
    }

    public function usePerson(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'use_person_id');
    }

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }
}
