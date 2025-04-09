<?php

declare(strict_types=1);

namespace App\Http\DTO\Layout;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class LayoutDragDropData extends Data
{
    public function __construct(
        public int    $employeeId,
        public int    $systemId,
        public string $block,
        public ?int   $id = null,
        public ?int   $blockOrder = null,
    )
    {

    }

}
