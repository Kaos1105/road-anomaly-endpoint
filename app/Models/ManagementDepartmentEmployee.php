<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperManagementDepartmentEmployee
 */
class ManagementDepartmentEmployee extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'management_department_id',
        'my_company_employee_id',

    ];

    public static $selectProps = [
        'negotiation_management_department_employees.id',
        'negotiation_management_department_employees.management_department_id',
        'negotiation_management_department_employees.my_company_employee_id',
    ];

    protected $table = 'negotiation_management_department_employees';

    public $timestamps = false;
    
    public function myCompanyEmployee(): BelongsTo
    {
        return $this->belongsTo(MyCompanyEmployee::class, 'my_company_employee_id');
    }

}
