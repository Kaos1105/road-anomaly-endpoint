<?php

declare(strict_types=1);

namespace App\Http\DTO\Announcement;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class AnnouncementCardDashboardData extends Data
{
    public function __construct(
        public ?bool       $isAccessible = false,
        public ?Collection $accessHistories = null,
        public ?Collection $announcements = null,
    )
    {

    }

}
