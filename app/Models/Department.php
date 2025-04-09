<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;


/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $employeeFavorites
 * @property-read int|null $employee_favorites_count
 * @property-read int|null $suppliers_count
 * @mixin IdeHelperDepartment
 */
class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'site_id',
        'long_name',
        'code',
        'short_name',
        'kana',
        'start_date',
        'end_date',
        'represent_flg',
        'department_classification',
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
        'organization_departments.id',
        'organization_departments.site_id',
        'organization_departments.long_name',
        'organization_departments.code',
        'organization_departments.short_name',
        'organization_departments.kana',
        'organization_departments.start_date',
        'organization_departments.end_date',
        'organization_departments.represent_flg',
        'organization_departments.department_classification',
        'organization_departments.previous_name',
        'organization_departments.previous_name_flg',
        'organization_departments.en_notation',
        'organization_departments.phone',
        'organization_departments.memo',
        'organization_departments.display_order',
        'organization_departments.use_classification',
        'organization_departments.created_by',
        'organization_departments.updated_by',
        'organization_departments.created_at',
        'organization_departments.updated_at',
    ];

    protected $table = 'organization_departments';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
        'updated_at' => 'datetime:Y-m-d H:m',
    ];

    public function attachmentFiles(): MorphMany
    {
        return $this->morphMany(AttachmentFile::class, 'attachable');
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'updated_by');
    }

    public function company(): HasOneThrough
    {
        return $this->hasOneThrough(
            Company::class,
            Site::class,
            'id',
            'id',
            'site_id',
            'company_id'
        );
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

    public function divisions(): HasMany
    {
        return $this->hasMany(Division::class, 'department_id', 'id');
    }


    public function employees(): HasManyThrough
    {
        return $this->hasManyThrough(
            Employee::class,
            Transfer::class,
            'department_id',
            'id',
            'id',
            'employee_id'
        );
    }

    public function transfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'department_id', 'id');
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'accounting_department_id', 'id');
    }

    public function managementDepartments(): HasMany
    {
        return $this->hasMany(ManagementDepartment::class, 'department_id', 'id');
    }

}
