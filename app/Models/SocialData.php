<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperSocialData
 */
class SocialData extends Model
{
    use HasFactory;

    protected $table = 'social_social_datas';

    protected $fillable = [
        'id',
        'social_event_id',
        'customer_id',
        'display_transfer_id',
        'product_id',
        'product_name',
        'unit_price',
        'discount',
        'tax_classification_1',
        'tax_1',
        'shipping_cost',
        'tax_classification_2',
        'tax_2',
        'other',
        'tax_classification_3',
        'tax_3',
        'total_amount',
        'total_tax',
        'purpose',
        'result',
        'processing_site',
        'accounting_company',
        'accounting_department_id',
        'address_classification',
        'data_progress',
        'comment_history',
        'memo',
        'display_order',
        'use_classification',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public static array $selectProps = [
        'social_social_datas.id',
        'social_social_datas.social_event_id',
        'social_social_datas.customer_id',
        'social_social_datas.display_transfer_id',
        'social_social_datas.product_id',
        'social_social_datas.product_name',
        'social_social_datas.unit_price',
        'social_social_datas.discount',
        'social_social_datas.tax_classification_1',
        'social_social_datas.tax_1',
        'social_social_datas.shipping_cost',
        'social_social_datas.tax_classification_2',
        'social_social_datas.tax_2',
        'social_social_datas.other',
        'social_social_datas.tax_classification_3',
        'social_social_datas.tax_3',
        'social_social_datas.total_amount',
        'social_social_datas.total_tax',
        'social_social_datas.purpose',
        'social_social_datas.result',
        'social_social_datas.processing_site',
        'social_social_datas.accounting_company',
        'social_social_datas.accounting_department_id',
        'social_social_datas.address_classification',
        'social_social_datas.data_progress',
        'social_social_datas.comment_history',
        'social_social_datas.memo',
        'social_social_datas.display_order',
        'social_social_datas.use_classification',
        'social_social_datas.created_by',
        'social_social_datas.updated_by',
        'social_social_datas.created_at',
        'social_social_datas.updated_at',
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

    public function socialEvent(): BelongsTo
    {
        return $this->belongsTo(SocialEvent::class, 'social_event_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function displayTransfer(): BelongsTo
    {
        return $this->belongsTo(Transfer::class, 'display_transfer_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function accountingDepartment(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'accounting_department_id');
    }

    public function workflows(): HasMany
    {
        return $this->hasMany(Workflow::class, 'social_data_id');
    }
}
