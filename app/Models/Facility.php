<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin IdeHelperFacility
 */
class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'facility_group_id',
        'responsible_user_id',
        'usage_method',
        'name',
        'facility_classification',
        'aggregation_classification',
        'memo',
        'display_order',
        'use_classification',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public static array $selectProps = [
        'facility_facilities.id',
        'facility_facilities.facility_group_id',
        'facility_facilities.responsible_user_id',
        'facility_facilities.usage_method',
        'facility_facilities.name',
        'facility_facilities.facility_classification',
        'facility_facilities.aggregation_classification',
        'facility_facilities.memo',
        'facility_facilities.display_order',
        'facility_facilities.use_classification',
        'facility_facilities.created_by',
        'facility_facilities.updated_by',
        'facility_facilities.created_at',
        'facility_facilities.updated_at',
    ];

    protected $table = 'facility_facilities';

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

    public function responsibleUser(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'responsible_user_id');
    }

    public function facilityGroup(): BelongsTo
    {
        return $this->belongsTo(FacilityGroup::class, 'facility_group_id');
    }

    public function attachmentFiles(): MorphMany
    {
        return $this->morphMany(AttachmentFile::class, 'attachable');
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'facility_id');
    }
}
