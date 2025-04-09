<?php

declare(strict_types=1);

namespace App\Http\DTO\Portal;

use App\Http\DTO\Facility\FacilityPortalData;
use App\Http\Resources\Announcement\AnnouncementPortalCardResource;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class FacilityCardData extends Data
{
    public function __construct(
        public ?bool               $isAccessible = false,
        public ?bool               $isOperationSystem = false,
        public ?string             $message = null,
        public ?FacilityPortalData $schedule = null,
        public ?Collection         $announcements = null,
    )
    {
        $this->announcements = $announcements ? AnnouncementPortalCardResource::collection($announcements)->collection : null;

    }
}
