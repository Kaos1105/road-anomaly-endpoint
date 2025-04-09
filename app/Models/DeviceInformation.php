<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperDeviceInformation
 */
class DeviceInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'employee_id',
        'name',
        'device_information',
        'device_token',
        'use_classification',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public static $selectProps = [
        'main_device_informations.id',
        'main_device_informations.employee_id',
        'main_device_informations.name',
        'main_device_informations.device_information',
        'main_device_informations.device_token',
        'main_device_informations.use_classification',
        'main_device_informations.created_by',
        'main_device_informations.updated_by',
        'main_device_informations.created_at',
        'main_device_informations.updated_at',

    ];

    protected $table = 'main_device_informations';

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
