<?php

declare(strict_types=1);

namespace App\Http\DTO\WeeklySchedule;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class ScheduleDragNDropData extends Data
{
    public function __construct(
        public int $id,
        public int $displayOrder,
    )
    {

    }
}
