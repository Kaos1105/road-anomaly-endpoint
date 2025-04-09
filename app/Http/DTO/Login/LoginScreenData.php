<?php

declare(strict_types=1);

namespace App\Http\DTO\Login;

use App\Http\Resources\Announcement\AnnouncementDisplayResource;
use App\Http\Resources\Display\Content\ContentItemNotPermissionResource;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class LoginScreenData extends Data
{
    public function __construct(
        public ?Collection $contents = null,
        public ?Collection $announcements = null,
    )
    {
        $this->contents = $contents ? ContentItemNotPermissionResource::collection($contents)->collection : null;
        $this->announcements = $announcements ? AnnouncementDisplayResource::collection($announcements)->collection : null;
    }

}
