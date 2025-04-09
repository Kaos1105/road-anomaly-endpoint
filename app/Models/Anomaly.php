<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperAnomaly
 */
class Anomaly extends Model
{
    protected $fillable = [
        'region', 'lat', 'lon', 'timestamp', 'record_date_time', 'label'
    ];

    protected $table = 'anomalies';

    public function sensorData(): HasMany
    {
        return $this->hasMany(SensorData::class);
    }
}
