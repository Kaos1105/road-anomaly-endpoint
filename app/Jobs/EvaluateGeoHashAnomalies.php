<?php

namespace App\Jobs;

use App\Events\AnomalyClusterDetected;
use App\Models\Anomaly;
use Cache;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EvaluateGeoHashAnomalies implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $geoHash;

    public function __construct(string $geoHash)
    {
        $this->geoHash = $geoHash;
    }

    public function handle(): void
    {
        $lockKey = "handling-geoHash-{$this->geoHash}";

        Cache::lock($lockKey, 30)->get(function (){
            $count = Anomaly::where('timestamp', '>=', now()->subDay())
                ->where('region', $this->geoHash)->where('label', 'L-UNEVEN')
                ->count();
            \Log::info($this->geoHash);
            if ($count >= 2) {
                broadcast(new AnomalyClusterDetected($this->geoHash));
            }
        });
    }
}
