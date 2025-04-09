<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * @mixin IdeHelperSupplier
 */
class Supplier extends Model
{
    use HasFactory;

    protected $table = 'social_suppliers';

    protected $fillable = [
        'id',
        'sales_store_id',
        'supplier_classification',
        'supplier_person_id',
        'my_company_person_id',
        'memo',
        'display_order',
        'use_classification',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    public static array $selectProps = [
        'social_suppliers.id',
        'social_suppliers.sales_store_id',
        'social_suppliers.supplier_classification',
        'social_suppliers.supplier_person_id',
        'social_suppliers.my_company_person_id',
        'social_suppliers.memo',
        'social_suppliers.display_order',
        'social_suppliers.use_classification',
        'social_suppliers.created_by',
        'social_suppliers.created_at',
        'social_suppliers.updated_by',
        'social_suppliers.updated_at',
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

    public function company(): HasOneThrough
    {
        return $this->hasOneThrough(
            Company::class,
            Site::class,
            'id',
            'id',
            'sales_store_id',
            'company_id'
        );
    }

    public function salesStore(): BelongsTo
    {
        return $this->belongsTo(Site::class, 'sales_store_id');
    }

    public function supplierPerson(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'supplier_person_id');
    }

    public function myCompanyPerson(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'my_company_person_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'supplier_id');
    }
}
