<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperClientSite
 */
class ClientSite extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'management_department_id',
        'site_id',
        'memo',
        'display_order',
        'use_classification',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public static $selectProps = [
        'negotiation_client_sites.id',
        'negotiation_client_sites.site_id',
        'negotiation_client_sites.management_department_id',
        'negotiation_client_sites.memo',
        'negotiation_client_sites.display_order',
        'negotiation_client_sites.use_classification',
        'negotiation_client_sites.created_by',
        'negotiation_client_sites.updated_by',
        'negotiation_client_sites.created_at',
        'negotiation_client_sites.updated_at',
    ];

    protected $table = 'negotiation_client_sites';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
        'updated_at' => 'datetime:Y-m-d H:m',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'updated_by');
    }

    public function clientEmployees(): HasMany
    {
        return $this->hasMany(ClientEmployee::class, 'client_site_id');
    }

    public function negotiations(): HasMany
    {
        return $this->hasMany(Negotiation::class, 'client_site_id');
    }
}
