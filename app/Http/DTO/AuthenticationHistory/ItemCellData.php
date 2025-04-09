<?php

declare(strict_types=1);

namespace App\Http\DTO\AuthenticationHistory;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class ItemCellData extends Data
{
    public function __construct(
        public ?int $jan = 0,
        public ?int $feb = 0,
        public ?int $mar = 0,
        public ?int $apr = 0,
        public ?int $may = 0,
        public ?int $jun = 0,
        public ?int $jul = 0,
        public ?int $aug = 0,
        public ?int $sep = 0,
        public ?int $oct = 0,
        public ?int $nov = 0,
        public ?int $dec = 0,
        public ?int $year = 0,
        public ?int $lastYear = 0,
        public ?int $twoYearAgo = 0,
    )
    {

    }
}
