<?php

declare(strict_types=1);

namespace App\Http\DTO\AccessHistory;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class SummaryUserSystemData extends Data
{
    public function __construct(
        public ?string $code = null,
        public ?int    $value = 0,
    )
    {
    }
}
