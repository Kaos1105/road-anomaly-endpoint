<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperContractCondition
 */
class ContractCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'basic_contract_id',
        'condition_classification',
        'code',
        'content',
        'memo',
        'display_order',
        'use_classification',
        'created_by',
        'updated_by',
    ];

    public static $selectProps = [
        'contract_contract_conditions.id',
        'contract_contract_conditions.basic_contract_id',
        'contract_contract_conditions.condition_classification',
        'contract_contract_conditions.code',
        'contract_contract_conditions.content',
        'contract_contract_conditions.memo',
        'contract_contract_conditions.display_order',
        'contract_contract_conditions.use_classification',
        'contract_contract_conditions.created_by',
        'contract_contract_conditions.updated_by',
        'contract_contract_conditions.created_at',
        'contract_contract_conditions.updated_at',
    ];

    protected $table = 'contract_contract_conditions';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
        'updated_at' => 'datetime:Y-m-d H:m',
    ];

    public function basicContract(): BelongsTo
    {
        return $this->belongsTo(BasicContract::class, 'basic_contract_id');
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
