<?php

namespace App\Http\DTO\QueryParam;

use App\Enums\Common\UseFlagEnum;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class CompanyDropdownNegotiationParam extends Data
{
    public function __construct(
        public ?int  $useClassification = UseFlagEnum::USE,
        public ?bool $clientCompany = true,
    )
    {
    }
}
