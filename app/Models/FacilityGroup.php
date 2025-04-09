<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperFacilityGroup
 */
class FacilityGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'use_group_id',
        'name',
        'memo',
        'display_order',
        'use_classification',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public static array $selectProps = [
        'facility_facility_groups.id',
        'facility_facility_groups.use_group_id',
        'facility_facility_groups.name',
        'facility_facility_groups.memo',
        'facility_facility_groups.display_order',
        'facility_facility_groups.use_classification',
        'facility_facility_groups.created_by',
        'facility_facility_groups.updated_by',
        'facility_facility_groups.created_at',
        'facility_facility_groups.updated_at',
    ];

    protected $table = 'facility_facility_groups';

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

    public function useGroup(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'use_group_id');
    }

    public function facilities(): HasMany
    {
        return $this->hasMany(Facility::class, 'facility_group_id', 'id');
    }

    public function userSettings(): HasMany
    {
        return $this->hasMany(FacilityUserSetting::class, 'facility_group_id', 'id');
    }

}
