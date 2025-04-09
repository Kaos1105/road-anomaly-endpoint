<?php

declare(strict_types=1);

namespace App\Http\DTO\AuthenticationHistory;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class YearData extends Data
{
    public function __construct(
        public ?int    $year = null,
        public ?int    $actionCount = 0,
        public ?string $action = null,
    )
    {

    }
}
