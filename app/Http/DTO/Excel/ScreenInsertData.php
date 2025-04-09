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
class ScreenInsertData extends Data
{
    public function __construct(
        public ?string $system_id,
        public ?string $code,
        public ?int    $display_classification,
        public ?string $name,
        public ?string $memo,
        public ?int    $display_order = DisplayOrderEnum::DEFAULT,
        public ?int    $use_classification = UseFlagEnum::NOT_USE,
        public ?int    $created_by = null,
        public ?int    $updated_by = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
    )
    {
    }

}
