<?php

namespace App\Http\DTO\QueryParam;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class ClientSiteDropdownParam extends Data
{
    public function __construct(
        public ?int  $useClassification = null,
        public ?int  $managementDepartmentId = -1,
        public ?bool $negotiation = false,
    )
    {
    }
}
