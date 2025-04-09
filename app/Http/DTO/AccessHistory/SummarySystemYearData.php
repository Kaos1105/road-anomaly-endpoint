<?php

declare(strict_types=1);

namespace App\Http\DTO\AccessHistory;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class SummarySystemYearData extends Data
{
    public function __construct(
        public ?int $year = null,
        public ?int $accessCount = 0,
        public ?int $systemId = null,

    )
    {

    }

}
