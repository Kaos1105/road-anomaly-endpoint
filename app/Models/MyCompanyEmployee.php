<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin IdeHelperMyCompanyEmployee
 */
class MyCompanyEmployee extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'employee_id',
        'position_classification',
        'memo',
        'display_order',
        'use_classification',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public static $selectProps = [
        'negotiation_my_company_employees.id',
        'negotiation_my_company_employees.employee_id',
        'negotiation_my_company_employees.position_classification',
        'negotiation_my_company_employees.memo',
        'negotiation_my_company_employees.display_order',
        'negotiation_my_company_employees.use_classification',
        'negotiation_my_company_employees.created_by',
        'negotiation_my_company_employees.updated_by',
        'negotiation_my_company_employees.created_at',
        'negotiation_my_company_employees.updated_at',
    ];

    protected $table = 'negotiation_my_company_employees';

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

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function managementDepartments(): BelongsToMany
    {
        return $this->belongsToMany(ManagementDepartment::class, 'negotiation_management_department_employees')
            ->withPivot('id');
    }

    public function negotiable(): MorphMany
    {
        return $this->morphMany(NegotiationEmployee::class, 'negotiable');
    }

}
