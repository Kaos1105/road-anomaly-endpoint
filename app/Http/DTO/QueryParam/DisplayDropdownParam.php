<?php

namespace App\Http\DTO\QueryParam;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
#[MapInputName(SnakeCaseMapper::class)]
class DisplayDropdownParam extends Data
{
    public function __construct(
        public ?int    $id = null,
        public ?int    $systemId = null,
        public ?string $search = null,
    )
    {
    }
}
