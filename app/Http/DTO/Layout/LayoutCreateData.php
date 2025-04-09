<?php

declare(strict_types=1);

namespace App\Http\DTO\Layout;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class LayoutCreateData extends Data
{
    public function __construct(
        public ?int    $employeeId = null,
        public ?int    $systemId = null,
        public ?string $block = null,
        public ?int    $blockOrder = null,
        public ?string $contentNo = null,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,

    )
    {

    }

}
