<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperSensorData
 */
class SensorData extends Model
{
    protected $fillable = [
        'anomaly_id', 'timestamp', 'record_date_time', 'gyro_mag', 'accel_mag'
    ];

    protected $table = 'sensor_data';

    public function anomaly(): BelongsTo
    {
        return $this->belongsTo(Anomaly::class);
    }
}
