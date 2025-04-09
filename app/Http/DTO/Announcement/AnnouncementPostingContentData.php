<?php

declare(strict_types=1);

namespace App\Http\DTO\Announcement;

use App\Http\Resources\Announcement\AnnouncementDisplayResource;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class AnnouncementPostingContentData extends Data
{
    public function __construct(
        public ?bool       $isNew = false,
        public ?Collection $announcements = null,
    )
    {
        $this->announcements = $announcements ? AnnouncementDisplayResource::collection($announcements)->collection : null;
    }

}
