<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property-read int $customer_count
 * @mixin IdeHelperTransfer
 */
class Transfer extends Model
{
    use HasFactory;

    protected $table = 'organization_transfers';

    protected $fillable = [
        'id',
        'company_id',
        'site_id',
        'department_id',
        'division_id',
        'employee_id',
        'team_name',
        'position',
        'contract_classification',
        'start_date',
        'end_date',
        'represent_flg',
        'transfer_classification',
        'major_history_flg',
        'memo',
        'display_order',
        'created_by',
        'updated_by',
    ];

    public static array $selectProps = [
        'organization_transfers.id',
        'organization_transfers.company_id',
        'organization_transfers.site_id',
        'organization_transfers.department_id',
        'organization_transfers.division_id',
        'organization_transfers.employee_id',
        'organization_transfers.team_name',
        'organization_transfers.position',
        'organization_transfers.contract_classification',
        'organization_transfers.start_date',
        'organization_transfers.end_date',
        'organization_transfers.represent_flg',
        'organization_transfers.transfer_classification',
        'organization_transfers.major_history_flg',
        'organization_transfers.memo',
        'organization_transfers.display_order',
        'organization_transfers.created_by',
        'organization_transfers.updated_by',
        'organization_transfers.created_at',
        'organization_transfers.updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
        'updated_at' => 'datetime:Y-m-d H:m',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'updated_by');
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'display_transfer_id', 'id');
    }
}
