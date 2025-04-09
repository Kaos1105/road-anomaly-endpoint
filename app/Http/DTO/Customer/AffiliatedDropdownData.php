<?php

declare(strict_types=1);

namespace App\Http\DTO\Customer;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class AffiliatedDropdownData extends Data
{
    public function __construct(
        public Collection $responsibleEmployees,
        public Collection $accountingDepartments,
        public Collection $companies,
    )
    {
    }
}
