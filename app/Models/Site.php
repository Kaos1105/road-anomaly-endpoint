<?php

namespace App\Models;

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
 * @mixin IdeHelperSite
 */
class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'code',
        'company_id',
        'long_name',
        'short_name',
        'kana',
        'start_date',
        'end_date',
        'represent_flg',
        'site_classification',
        'previous_name',
        'previous_name_flg',
        'en_notation',
        'post_code',
        'address_1',
        'address_2',
        'address_3',
        'phone',
        'area_name',
        'memo',
        'display_order',
        'use_classification',
        'created_by',
        'updated_by',
    ];

    public static array $selectProps = [
        'organization_sites.id',
        'organization_sites.code',
        'organization_sites.company_id',
        'organization_sites.long_name',
        'organization_sites.short_name',
        'organization_sites.kana',
        'organization_sites.start_date',
        'organization_sites.end_date',
        'organization_sites.represent_flg',
        'organization_sites.site_classification',
        'organization_sites.previous_name',
        'organization_sites.previous_name_flg',
        'organization_sites.en_notation',
        'organization_sites.post_code',
        'organization_sites.address_1',
        'organization_sites.address_2',
        'organization_sites.address_3',
        'organization_sites.phone',
        'organization_sites.area_name',
        'organization_sites.memo',
        'organization_sites.display_order',
        'organization_sites.use_classification',
        'organization_sites.created_by',
        'organization_sites.created_at',
        'organization_sites.updated_by',
        'organization_sites.updated_at',
    ];

    protected $table = 'organization_sites';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
        'updated_at' => 'datetime:Y-m-d H:m',
    ];


    public function attachmentFiles(): MorphMany
    {
        return $this->morphMany(AttachmentFile::class, 'attachable');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class, 'site_id', 'id');
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
            'site_id',
            'id',
            'id',
            'employee_id'
        );
    }

    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class, 'sales_store_id', 'id');
    }

    public function clientSite(): HasOne
    {
        return $this->hasOne(ClientSite::class, 'site_id', 'id');
    }

    public function ourSiteContract(): HasMany
    {
        return $this->hasMany(BasicContract::class, 'site_id', 'id');
    }

    public function counterparty(): HasMany
    {
        return $this->hasMany(BasicContract::class, 'counterparty_id', 'id');
    }
}
