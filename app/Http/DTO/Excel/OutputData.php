<?php

declare(strict_types=1);

namespace App\Http\DTO\Excel;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class OutputData extends Data
{
    public function __construct(
        public ?int                  $code,
        public ?string               $action = null,
        public Collection|array|null $data = null,
        public ?string               $message = null,
    )
    {
    }
}
