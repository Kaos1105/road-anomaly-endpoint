<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperContractWorkplace
 */
class ContractWorkplace extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'basic_contract_id',
        'division_id',
        'memo',
        'display_order',
        'use_classification',
        'created_by',
        'updated_by',
    ];

    public static $selectProps = [
        'contract_contract_workplaces.id',
        'contract_contract_workplaces.basic_contract_id',
        'contract_contract_workplaces.division_id',
        'contract_contract_workplaces.memo',
        'contract_contract_workplaces.display_order',
        'contract_contract_workplaces.use_classification',
        'contract_contract_workplaces.created_by',
        'contract_contract_workplaces.updated_by',
        'contract_contract_workplaces.created_at',
        'contract_contract_workplaces.updated_at',
    ];

    protected $table = 'contract_contract_workplaces';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
        'updated_at' => 'datetime:Y-m-d H:m',
    ];

    public function basicContract(): BelongsTo
    {
        return $this->belongsTo(BasicContract::class, 'basic_contract_id');
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'updated_by');
    }

}
