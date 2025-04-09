<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin IdeHelperProduct
 */
class Product extends Model
{
    use HasFactory;

    protected $table = 'social_products';

    protected $fillable = [
        'id',
        'supplier_id',
        'product_classification',
        'code',
        'name',
        'unit_price',
        'tax_classification_1',
        'tax_classification_2',
        'tax_classification_3',
        'memo',
        'display_order',
        'use_classification',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    public static array $selectProps = [
        'social_products.id',
        'social_products.supplier_id',
        'social_products.product_classification',
        'social_products.code',
        'social_products.name',
        'social_products.unit_price',
        'social_products.tax_classification_1',
        'social_products.tax_classification_2',
        'social_products.tax_classification_3',
        'social_products.memo',
        'social_products.display_order',
        'social_products.use_classification',
        'social_products.created_by',
        'social_products.created_at',
        'social_products.updated_by',
        'social_products.updated_at',
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

    public function site(): HasOneThrough
    {
        return $this->hasOneThrough(
            Site::class,
            Supplier::class,
            'id',
            'id',
            'supplier_id',
            'sales_store_id'
        );
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function socialData(): HasMany
    {
        return $this->hasMany(SocialData::class, 'product_id');
    }

    public function attachmentFiles(): MorphMany
    {
        return $this->morphMany(AttachmentFile::class, 'attachable');
    }
}
