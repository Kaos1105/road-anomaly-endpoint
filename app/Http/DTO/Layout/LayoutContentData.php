<?php

declare(strict_types=1);

namespace App\Http\DTO\Layout;

use App\Http\Resources\Announcement\AnnouncementDisplayResource;
use App\Http\Resources\Display\Content\ContentItemNotPermissionResource;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class LayoutContentData extends Data
{
    public function __construct(
        public ?int    $id = null,
        public ?int    $systemId = null,
        public ?string $contentNo = null,
        public ?string $block = null,
        public ?int    $blockOrder = null,

    )
    {

    }

}
