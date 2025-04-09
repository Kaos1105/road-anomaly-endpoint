<?php

namespace App\Http\DTO\QueryParam;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class NegotiationCalendarParam extends Data
{
    public function __construct(
        public ?string $date = null,
        public ?array  $clientSiteIds = null,
    )
    {
    }
}
