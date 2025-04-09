<?php

declare(strict_types=1);

namespace App\Http\DTO\Layout;

use App\Enums\Layout\LayoutBlockEnum;
use App\Models\Layout;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\CamelCaseMapper;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(CamelCaseMapper::class)]
class DashboardLayoutData extends Data
{
    public function __construct(
        public ?Collection $blockA = null,
        public ?Collection $blockB = null,
        public ?Collection $blockC = null,

    )
    {

    }

    public static function fromCollection(Collection $layoutCollection): DashboardLayoutData
    {
        $blocks = $layoutCollection->groupBy('block')->map(function (Collection $block) {
            return $block->map(fn(Layout $layout) => LayoutContentData::from($layout));
        });

        return new DashboardLayoutData(
            $blocks->get(LayoutBlockEnum::BLOCK_A),
            $blocks->get(LayoutBlockEnum::BLOCK_B),
            $blocks->get(LayoutBlockEnum::BLOCK_C)
        );
    }

}
