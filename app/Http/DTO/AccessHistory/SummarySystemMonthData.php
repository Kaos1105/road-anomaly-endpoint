<?php

declare(strict_types=1);

namespace App\Http\DTO\AccessHistory;

use App\Models\AccessHistory;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class SummarySystemMonthData extends Data
{
    public function __construct(
        public ?string $month = null,
        public ?int    $accessCount = 0,
        public ?int    $systemId = null,

    )
    {

    }

    public static function mapCollection(Collection $monthly): Collection
    {
        return $monthly->map(function (AccessHistory $item) {
            return SummarySystemMonthData::from($item);
        });
    }
}
