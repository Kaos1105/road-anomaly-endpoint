<?php

namespace App\Http\Controllers;

use App\Jobs\EvaluateGeoHashAnomalies;
use App\Models\Anomaly;
use App\Trait\HandleResponse;
use Cache;
use Carbon\Carbon;
use Geotools\Coordinate\Coordinate;
use Geotools\Geotools;
use Illuminate\Http\Request;

class AnomalyUploadController extends Controller
{
    use HandleResponse;
    public function __construct(
    )
    {
    }

    public function upload(Request $request): \App\Http\DTO\ResponseData
    {
        foreach ($request->file('files') as $file) {
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            [$timestampStr, $label] = explode('_', $filename, 2);
            $timestamp = Carbon::createFromTimestampMs($timestampStr);
            $recordDateTime = $timestamp->toDateTimeString();

            $rows = array_map('str_getcsv', file($file->getRealPath()));
            $header = array_map('trim', array_shift($rows));

            $firstRow = array_combine($header, $rows[0]);
            $lat = $firstRow['latitude'];
            $lon = $firstRow['longitude'];
            $geoTools = new Geotools();
            $coordinateToGeoHash = new Coordinate([$lat, $lon]);
            $encoded = $geoTools->geohash()->encode($coordinateToGeoHash, 9);
            $region = $encoded->getGeohash();
            $anomaly = Anomaly::create([
                'region' => $region,
                'lat' => $lat,
                'lon' => $lon,
                'timestamp' => $timestamp,
                'record_date_time' => $recordDateTime,
                'label' => $label,
            ]);

            $sensorData = [];
            foreach ($rows as $row) {
                $data = array_combine($header, $row);
                $sensorData[] = [
                    'timestamp' => $data['timestamp'],
                    'record_date_time' => Carbon::createFromFormat('j/n/Y H:i', $data['recordDateTime']),
                    'gyro_mag' => $data['gyroMag'],
                    'accel_mag' => $data['accelMag'],
                ];
            }
            $anomaly->sensorData()->createMany($sensorData);

            $lockKey = "evaluate-geoHash-{$region}";
            Cache::lock($lockKey, 30)->get(function () use ($region){
                EvaluateGeohashAnomalies::dispatch($region);
            });
        }

        return $this->httpOk();
    }
}
