<?php

namespace App\Http\DTO\Social;

use App\Http\Resources\SocialEvent\SocialEventDashboardResource;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class SocialEventDashboardData extends Data
{
    public function __construct(
        public bool        $isEnableBtn,
        public ?Collection $socialEvents,
    )
    {
        $this->socialEvents = $socialEvents ? SocialEventDashboardResource::collection($socialEvents)->collection : null;
    }
}
