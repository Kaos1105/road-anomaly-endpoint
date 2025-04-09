<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperFacilityUserSetting
 */
class FacilityUserSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'holiday_display',
        'facility_group_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public static array $selectProps = [
        'facility_user_settings.id',
        'facility_user_settings.user_id',
        'facility_user_settings.holiday_display',
        'facility_user_settings.facility_group_id',
        'facility_user_settings.created_by',
        'facility_user_settings.updated_by',
        'facility_user_settings.created_at',
        'facility_user_settings.updated_at',
    ];

    protected $table = 'facility_user_settings';

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'user_id');
    }

    public function facilityGroup(): BelongsTo
    {
        return $this->belongsTo(FacilityGroup::class, 'facility_group_id');
    }
}
