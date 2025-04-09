<?php

declare(strict_types=1);

namespace App\Http\DTO\AuthenticationHistory;

use App\Models\AuthenticationHistory;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class MonthData extends Data
{
    public function __construct(
        public ?string $month = null,
        public ?int    $actionCount = 0,
        public ?string $action = null,

    )
    {

    }

    public static function mapCollection(Collection $monthly): Collection
    {
        return $monthly->map(function (AuthenticationHistory $item) {
            return MonthData::from($item);
        });
    }
}
