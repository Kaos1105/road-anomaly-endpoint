<?php

declare(strict_types=1);

namespace App\Http\DTO\AccessHistory;

use App\Helpers\DateTimeHelper;
use App\Models\AccessHistory;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class SummaryGraphHourData extends Data
{
    public function __construct(
        public string|int      $hour,
        public string|int|null $value = '0.0',
    )
    {
        $this->hour = DateTimeHelper::formatHourToString($hour);
    }

    public static function mapCollection(Collection $defaultHours, ?Collection $hourCollection): Collection
    {
        if ($hourCollection->isEmpty()) {
            return $defaultHours;
        }
        $hourCollection = $hourCollection->map(fn(AccessHistory $accessHistory) => new SummaryGraphHourData($accessHistory->hour, $accessHistory->access_count));

        return $hourCollection->merge($defaultHours)->unique('hour')->sortBy('hour')->values();
    }
}
