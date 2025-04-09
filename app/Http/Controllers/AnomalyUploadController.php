<?php

namespace App\Http\Controllers;

use App\Jobs\EvaluateGeoHashAnomalies;
use App\Models\Anomaly;
use Cache;
use Carbon\Carbon;
use Geotools\Coordinate\Coordinate;
use Geotools\Geotools;
use Request;

class AnomalyUploadController extends Controller
{
    public function __construct(
    )
    {
    }

    public function upload(Request $request): \Illuminate\Http\JsonResponse
    {
        foreach ($request->file('files') as $file) {
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            [$timestampStr, $label] = explode('_', $filename, 2);
            $timestamp = Carbon::createFromTimestamp($timestampStr);
            $recordDateTime = $timestamp->toDateTimeString();

            $rows = array_map('str_getcsv', file($file->getRealPath()));
            $header = array_map('trim', array_shift($rows));

            $firstRow = array_combine($header, $rows[0]);
            $lat = $firstRow['lat'];
            $lon = $firstRow['lon'];
            $geoTools       = new Geotools();
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
                    'record_date_time' => $data['recordDateTime'],
                    'gyro_mag' => $data['gyroMag'],
                    'accel_mag' => $data['accelMag'],
                ];
            }
            $anomaly->sensorData()->createMany($sensorData);

            $lockKey = "evaluate-geoHash-{$region}";
            if (Cache::lock($lockKey, 30)->get()) {
                EvaluateGeohashAnomalies::dispatch($region);
            }
        }

        return response()->json(['status' => 'success']);
    }
}
