<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin IdeHelperBasicContract
 */
class BasicContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'code',
        'signing_at',
        'counterparty_id',
        'counterparty_contractor_id',
        'counterparty_representative_id',
        'site_id',
        'contractor_id',
        'representative_id',
        'no',
        'name',
        'approval_flag',
        'memo',
        'display_order',
        'use_classification',
        'created_by',
        'updated_by',
    ];

    public static $selectProps = [
        'contract_basic_contracts.id',
        'contract_basic_contracts.code',
        'contract_basic_contracts.signing_at',
        'contract_basic_contracts.counterparty_id',
        'contract_basic_contracts.counterparty_contractor_id',
        'contract_basic_contracts.counterparty_representative_id',
        'contract_basic_contracts.site_id',
        'contract_basic_contracts.contractor_id',
        'contract_basic_contracts.representative_id',
        'contract_basic_contracts.no',
        'contract_basic_contracts.name',
        'contract_basic_contracts.approval_flag',
        'contract_basic_contracts.memo',
        'contract_basic_contracts.display_order',
        'contract_basic_contracts.use_classification',
        'contract_basic_contracts.created_by',
        'contract_basic_contracts.updated_by',
        'contract_basic_contracts.created_at',
        'contract_basic_contracts.updated_at',
    ];

    protected $table = 'contract_basic_contracts';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
        'updated_at' => 'datetime:Y-m-d H:m',
    ];

    public function attachmentFiles(): MorphMany
    {
        return $this->morphMany(AttachmentFile::class, 'attachable');
    }

    public function counterparty(): BelongsTo
    {
        return $this->belongsTo(Site::class, 'counterparty_id');
    }

    public function counterpartyContractor(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'counterparty_contractor_id');
    }

    public function counterpartyRepresentative(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'counterparty_representative_id');
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function contractor(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'contractor_id');
    }

    public function representative(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'representative_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'updated_by');

    }

    public function contractWorkplaces(): HasMany
    {
        return $this->hasMany(ContractWorkplace::class, 'basic_contract_id', 'id');
    }

    public function contractConditions(): HasMany
    {
        return $this->hasMany(ContractCondition::class, 'basic_contract_id', 'id');
    }

    public function individualContracts(): HasMany
    {
        return $this->hasMany(IndividualContract::class, 'basic_contract_id', 'id');
    }

}
