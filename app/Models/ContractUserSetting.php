<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperContractUserSetting
 */
class ContractUserSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'employee_id',
        'notification_classification',
        'notification_range',
        'created_by',
        'updated_by',
    ];

    public static $selectProps = [
        'contract_user_settings.id',
        'contract_user_settings.employee_id',
        'contract_user_settings.notification_classification',
        'contract_user_settings.notification_range',
        'contract_user_settings.created_by',
        'contract_user_settings.updated_by',
        'contract_user_settings.created_at',
        'contract_user_settings.updated_at',
    ];

    protected $table = 'contract_user_settings';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
        'updated_at' => 'datetime:Y-m-d H:m',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
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
