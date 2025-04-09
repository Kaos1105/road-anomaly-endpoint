<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperWeeklySchedule
 */
class WeeklySchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'display_employee_id',
        'display_order',
        'display_weekly_classification',
    ];

    public static $selectProps = [
        'schedule_weekly_schedule.id',
        'schedule_weekly_schedule.user_id',
        'schedule_weekly_schedule.display_employee_id',
        'schedule_weekly_schedule.display_order',
        'schedule_weekly_schedule.display_weekly_classification',
    ];

    protected $table = 'schedule_weekly_schedule';

    public $timestamps = false;

    public function displayEmployee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'display_employee_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'user_id');
    }
}
