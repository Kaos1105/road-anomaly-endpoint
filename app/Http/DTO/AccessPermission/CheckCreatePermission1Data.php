<?php

declare(strict_types=1);

namespace App\Http\DTO\AccessPermission;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class CheckCreatePermission1Data extends SharedCheckPermission1Data
{
    public function __construct(
        public int     $systemId,
        public int     $permission_1,
        public ?string $startDate,
        public ?string $endDate,
    )
    {
        parent::__construct($this->permission_1, $this->startDate, $this->endDate);
    }
}
