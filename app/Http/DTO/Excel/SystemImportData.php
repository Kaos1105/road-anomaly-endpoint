<?php

declare(strict_types=1);

namespace App\Http\DTO\Excel;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Helpers\DateTimeHelper;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class SystemImportData extends Data
{
    public function __construct(
        public ?int    $row,
        public ?string $code_old,
        public ?string $code,
        public ?string $name,
        public ?string $overview,
        public ?string $start_date,
        public ?string $end_date,
        public ?int    $default_permission_2,
        public ?int    $default_permission_3,
        public ?int    $default_permission_4,
        public ?string $memo,
        public ?int    $display_order,
        public ?int    $use_classification,
    )
    {
        $this->start_date = DateTimeHelper::formatDateSystem($start_date);
        $this->end_date = DateTimeHelper::formatDateSystem($end_date);
        $this->display_order = $display_order ?: DisplayOrderEnum::DEFAULT;
        $this->use_classification = $use_classification ?: UseFlagEnum::NOT_USE;
    }
}
