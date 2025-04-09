<?php

namespace App\Models;

use App\Enums\Common\RepresentFlagEnum;
use App\Enums\Common\UseFlagEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $employeeFavorites
 * @property-read int|null $employee_favorites_count
 * @mixin IdeHelperCompany
 */
class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'code',
        'long_name',
        'short_name',
        'kana',
        'start_date',
        'end_date',
        'company_classification',
        'group_name',
        'previous_name',
        'previous_name_flg',
        'en_notation',
        'memo',
        'display_order',
        'use_classification',
        'created_by',
        'updated_by',
    ];

    public static $selectProps = [
        'organization_companies.id',
        'organization_companies.code',
        'organization_companies.long_name',
        'organization_companies.short_name',
        'organization_companies.kana',
        'organization_companies.start_date',
        'organization_companies.end_date',
        'organization_companies.company_classification',
        'organization_companies.group_name',
        'organization_companies.previous_name',
        'organization_companies.previous_name_flg',
        'organization_companies.en_notation',
        'organization_companies.memo',
        'organization_companies.display_order',
        'organization_companies.use_classification',
        'organization_companies.created_by',
        'organization_companies.updated_by',
        'organization_companies.created_at',
        'organization_companies.updated_at',
    ];

    protected $table = 'organization_companies';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
        'updated_at' => 'datetime:Y-m-d H:m',
    ];

    public function attachmentFiles(): MorphMany
    {
        return $this->morphMany(AttachmentFile::class, 'attachable');
    }

    public function sites(): HasMany
    {
        return $this->hasMany(Site::class, 'company_id', 'id');
    }

    public function siteRepresentative(): HasOne
    {
        return $this->hasOne(Site::class, 'company_id', 'id')
            ->where('represent_flg', '=', RepresentFlagEnum::REPRESENTATIVE)
            ->where('use_classification', '=', UseFlagEnum::USE)
            ->orderBy('display_order');
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
            'company_id',
            'id',
            'id',
            'employee_id'
        );
    }
}
