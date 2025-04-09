<?php

declare(strict_types=1);

namespace App\Http\DTO\Excel;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class ScreenImportData extends Data
{
    public function __construct(
        public ?int    $row,
        public ?string $system_code,
        public ?string $code_old,
        public ?string $code,
        public ?int    $display_classification,
        public ?string $name,
        public ?string $memo,
        public ?int    $display_order = DisplayOrderEnum::DEFAULT,
        public ?int    $use_classification = UseFlagEnum::NOT_USE,
    )
    {
    }

}
