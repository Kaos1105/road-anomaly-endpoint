<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $employeeFavorites
 * @property-read int|null $employee_favorites_count
 * @mixin IdeHelperDivision
 */
class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'department_id',
        'long_name',
        'code',
        'short_name',
        'kana',
        'start_date',
        'end_date',
        'represent_flg',
        'division_classification',
        'previous_name',
        'previous_name_flg',
        'en_notation',
        'phone',
        'memo',
        'display_order',
        'use_classification',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public static $selectProps = [
        'organization_divisions.id',
        'organization_divisions.department_id',
        'organization_divisions.long_name',
        'organization_divisions.code',
        'organization_divisions.short_name',
        'organization_divisions.kana',
        'organization_divisions.start_date',
        'organization_divisions.end_date',
        'organization_divisions.represent_flg',
        'organization_divisions.division_classification',
        'organization_divisions.previous_name',
        'organization_divisions.previous_name_flg',
        'organization_divisions.en_notation',
        'organization_divisions.phone',
        'organization_divisions.memo',
        'organization_divisions.display_order',
        'organization_divisions.use_classification',
        'organization_divisions.created_by',
        'organization_divisions.updated_by',
        'organization_divisions.created_at',
        'organization_divisions.updated_at',
    ];

    protected $table = 'organization_divisions';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
        'updated_at' => 'datetime:Y-m-d H:m',
    ];

    public function attachmentFiles(): MorphMany
    {
        return $this->morphMany(AttachmentFile::class, 'attachable');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'updated_by');
    }

    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favorable');
    }

    public function employeeFavorites(): MorphMany
    {
        return $this->favorites()
            ->where('employee_id', \Auth::user()->employee_id);
    }

    public function employees(): HasManyThrough
    {
        return $this->hasManyThrough(
            Employee::class,
            Transfer::class,
            'division_id',
            'id',
            'id',
            'employee_id'
        );
    }

    public function contractWorkplaces(): HasMany
    {
        return $this->hasMany(ContractWorkplace::class, 'division_id');
    }
}
