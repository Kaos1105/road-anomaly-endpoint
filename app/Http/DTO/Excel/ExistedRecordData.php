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
class ExistedRecordData extends Data
{
    public function __construct(
        public ?int        $id,
        public ?Collection $relation,
    )
    {
    }

}
