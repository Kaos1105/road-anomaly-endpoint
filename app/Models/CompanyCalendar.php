<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperCompanyCalendar
 */
class CompanyCalendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'company_id',
        'date',
        'calendar_classification',
        'calendar_contents',
        'work_classification',
    ];

    public static $selectProps = [
        'schedule_company_calendar.id',
        'schedule_company_calendar.company_id',
        'schedule_company_calendar.date',
        'schedule_company_calendar.calendar_classification',
        'schedule_company_calendar.calendar_contents',
        'schedule_company_calendar.work_classification',
    ];

    protected $table = 'schedule_company_calendar';

    public $timestamps = false;
    
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }


}
