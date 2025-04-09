<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SensorData> $sensorData
 * @property-read int|null $sensor_data_count
 * @method static \Illuminate\Database\Eloquent\Builder|Anomaly newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Anomaly newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Anomaly query()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAnomaly {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \App\Models\Anomaly|null $anomaly
 * @method static \Illuminate\Database\Eloquent\Builder|SensorData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SensorData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SensorData query()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSensorData {}
}

