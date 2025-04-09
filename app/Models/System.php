<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperSystem
 */
class System extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'code',
        'name',
        'overview',
        'start_date',
        'end_date',
        'default_permission_2',
        'default_permission_3',
        'default_permission_4',
        'memo',
        'display_order',
        'use_classification',
        'created_by',
        'updated_by',
    ];

    public static $selectProps = [
        'snet_systems.id',
        'snet_systems.code',
        'snet_systems.name',
        'snet_systems.overview',
        'snet_systems.start_date',
        'snet_systems.end_date',
        'snet_systems.default_permission_2',
        'snet_systems.default_permission_3',
        'snet_systems.default_permission_4',
        'snet_systems.memo',
        'snet_systems.display_order',
        'snet_systems.use_classification',
        'snet_systems.created_by',
        'snet_systems.created_at',
        'snet_systems.updated_by',
        'snet_systems.updated_at',
    ];

    protected $table = 'snet_systems';


    public function accessPermissions(): HasMany
    {
        return $this->hasMany(AccessPermission::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'updated_by');
    }

    public function displays(): HasMany
    {
        return $this->hasMany(Display::class);
    }
}
