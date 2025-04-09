<?php

declare(strict_types=1);

namespace App\Http\DTO\Portal;

use App\Http\DTO\Schedule\ScheduleBoxMainDashboardData;
use App\Http\Resources\Announcement\AnnouncementPortalCardResource;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class ScheduleManagementCardData extends Data
{
    public function __construct(
        public ?bool                         $isAccessible = false,
        public ?bool                         $isOperationSystem = false,
        public ?string                       $message = null,
        public ?ScheduleBoxMainDashboardData $schedule = null,
        public ?Collection                   $announcements = null,
    )
    {
        $this->announcements = $announcements ? AnnouncementPortalCardResource::collection($announcements)->collection : null;

    }
}
