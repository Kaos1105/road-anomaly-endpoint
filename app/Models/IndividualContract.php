<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin IdeHelperIndividualContract
 */
class IndividualContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'basic_contract_id',
        'start_date',
        'end_date',
        'name',
        'unit_price',
        'unit_classification',
        'unit_name',
        'rounding_method',
        'memo',
        'display_order',
        'use_classification',
        'created_by',
        'updated_by',
    ];

    public static $selectProps = [
        'contract_individual_contracts.id',
        'contract_individual_contracts.basic_contract_id',
        'contract_individual_contracts.start_date',
        'contract_individual_contracts.end_date',
        'contract_individual_contracts.name',
        'contract_individual_contracts.unit_price',
        'contract_individual_contracts.unit_classification',
        'contract_individual_contracts.unit_name',
        'contract_individual_contracts.rounding_method',
        'contract_individual_contracts.memo',
        'contract_individual_contracts.display_order',
        'contract_individual_contracts.use_classification',
        'contract_individual_contracts.created_by',
        'contract_individual_contracts.updated_by',
        'contract_individual_contracts.created_at',
        'contract_individual_contracts.updated_at',
    ];

    protected $table = 'contract_individual_contracts';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
        'updated_at' => 'datetime:Y-m-d H:m',
    ];

    public function attachmentFiles(): MorphMany
    {
        return $this->morphMany(AttachmentFile::class, 'attachable');
    }

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
