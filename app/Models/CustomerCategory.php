<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperCustomerCategory
 */
class CustomerCategory extends Model
{
    use HasFactory;

    protected $table = 'social_customer_categories';

    protected $fillable = [
        'id',
        'group_id',
        'name',
    ];

    public $timestamps = false;

    public static array $selectProps = [
        'social_customer_categories.id',
        'social_customer_categories.name',
        'social_customer_categories.group_id',
    ];

    public function managementGroup(): BelongsTo
    {
        return $this->belongsTo(ManagementGroup::class, 'group_id');
    }
}
