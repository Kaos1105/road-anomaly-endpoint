<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperGroup
 */
class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'display_order',
        'use_classification',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public static $selectProps = [
        'main_groups.id',
        'main_groups.name',
        'main_groups.display_order',
        'main_groups.use_classification',
        'main_groups.created_by',
        'main_groups.updated_by',
        'main_groups.created_at',
        'main_groups.updated_at',
    ];

    protected $table = 'main_groups';

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

    public function groupEmployees(): HasMany
    {
        return $this->hasMany(GroupEmployee::class, 'group_id', 'id');
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'main_group_members', 'group_id');
    }

    public function facilityGroup(): HasMany
    {
        return $this->hasMany(FacilityGroup::class, 'use_group_id', 'id');
    }

}
