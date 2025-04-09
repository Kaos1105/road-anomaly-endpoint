<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperDailySchedule
 */
class DailySchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'employee_id',
        'date',
        'work_classification',
    ];

    public static $selectProps = [
        'schedule_daily_schedule.id',
        'schedule_daily_schedule.employee_id',
        'schedule_daily_schedule.date',
        'schedule_daily_schedule.work_classification',

    ];

    protected $table = 'schedule_daily_schedule';

    public $timestamps = false;

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

}
