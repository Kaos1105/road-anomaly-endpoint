<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperAccessPermission
 */
class AccessPermission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'employee_id',
        'system_id',
        'permission_1',
        'permission_2',
        'permission_3',
        'permission_4',
        'start_date',
        'end_date',
        'memo',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    public static $selectProps = [
        'snet_access_permissions.id',
        'snet_access_permissions.employee_id',
        'snet_access_permissions.system_id',
        'snet_access_permissions.permission_1',
        'snet_access_permissions.permission_2',
        'snet_access_permissions.permission_3',
        'snet_access_permissions.permission_4',
        'snet_access_permissions.start_date',
        'snet_access_permissions.end_date',
        'snet_access_permissions.memo',
        'snet_access_permissions.created_by',
        'snet_access_permissions.updated_by',
        'snet_access_permissions.created_at',
        'snet_access_permissions.updated_at',
    ];

    protected $table = 'snet_access_permissions';

    public function system(): BelongsTo
    {
        return $this->belongsTo(System::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
