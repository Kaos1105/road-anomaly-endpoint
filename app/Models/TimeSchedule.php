<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperTimeSchedule
 */
class TimeSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'employee_id',
        'date',
        'start_time',
        'end_time',
        'work_contents',
        'work_place',
        'public_classification',
        'public_group_id',
        'updated_by',
        'updated_at',
    ];

    public static $selectProps = [
        'schedule_time_schedule.id',
        'schedule_time_schedule.employee_id',
        'schedule_time_schedule.date',
        'schedule_time_schedule.start_time',
        'schedule_time_schedule.end_time',
        'schedule_time_schedule.work_contents',
        'schedule_time_schedule.work_place',
        'schedule_time_schedule.public_classification',
        'schedule_time_schedule.public_group_id',
        'schedule_time_schedule.updated_by',
        'schedule_time_schedule.updated_at',
    ];

    protected $table = 'schedule_time_schedule';

    public $timestamps = false;

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'updated_by');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'public_group_id');
    }

    public function companyCalendar(): BelongsTo
    {
        return $this->belongsTo(CompanyCalendar::class, 'date', 'date');
    }

}
