<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperCustomer
 */
class Customer extends Model
{
    use HasFactory;

    protected $table = 'social_customers';

    protected $fillable = [
        'id',
        'employee_id',
        'display_transfer_id',
        'responsible_id',
        'category_name',
        'processing_site',
        'accounting_company',
        'accounting_department_id',
        'address_classification',
        'address_printing_1',
        'address_printing_2',
        'address_printing_3',
        'address_printing_4',
        'address_printing_5',
        'address_printing_6',
        'address_printing_7',
        'specified_post_code',
        'specified_address_1',
        'specified_address_2',
        'specified_address_3',
        'specified_phone',
        'update_order',
        'memo',
        'display_order',
        'use_classification',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    public static array $selectProps = [
        'social_customers.id',
        'social_customers.employee_id',
        'social_customers.display_transfer_id',
        'social_customers.responsible_id',
        'social_customers.category_name',
        'social_customers.processing_site',
        'social_customers.accounting_company',
        'social_customers.accounting_department_id',
        'social_customers.address_classification',
        'social_customers.address_printing_1',
        'social_customers.address_printing_2',
        'social_customers.address_printing_3',
        'social_customers.address_printing_4',
        'social_customers.address_printing_5',
        'social_customers.address_printing_6',
        'social_customers.address_printing_7',
        'social_customers.specified_post_code',
        'social_customers.specified_address_1',
        'social_customers.specified_address_2',
        'social_customers.specified_address_3',
        'social_customers.specified_phone',
        'social_customers.update_order',
        'social_customers.memo',
        'social_customers.display_order',
        'social_customers.use_classification',
        'social_customers.created_by',
        'social_customers.created_at',
        'social_customers.updated_by',
        'social_customers.updated_at',
    ];

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

    public function responsibleEmployee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'responsible_id');
    }

    public function displayTransfer(): BelongsTo
    {
        return $this->belongsTo(Transfer::class, 'display_transfer_id');
    }

    public function accountingDepartment(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'accounting_department_id');
    }

    public function socialData(): HasMany
    {
        return $this->hasMany(SocialData::class, 'customer_id', 'id');
    }
}
