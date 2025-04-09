<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperManagementDepartment
 */
class ManagementDepartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'department_id',
        'name',
        'memo',
        'display_order',
        'use_classification',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public static $selectProps = [
        'negotiation_management_departments.id',
        'negotiation_management_departments.department_id',
        'negotiation_management_departments.name',
        'negotiation_management_departments.memo',
        'negotiation_management_departments.display_order',
        'negotiation_management_departments.use_classification',
        'negotiation_management_departments.created_by',
        'negotiation_management_departments.updated_by',
        'negotiation_management_departments.created_at',
        'negotiation_management_departments.updated_at',
    ];

    protected $table = 'negotiation_management_departments';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
        'updated_at' => 'datetime:Y-m-d H:m',
    ];

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

    public function myCompanyEmployees(): BelongsToMany
    {
        return $this->belongsToMany(MyCompanyEmployee::class, 'negotiation_management_department_employees');
    }

}
