<?php

namespace App\Services\SocialData;

use App\Http\DTO\SocialData\UpdateProgressSocialData;
use App\Models\SocialData;
use App\Models\SocialEvent;
use App\Repositories\SocialData\ISocialDataRepository;
use Illuminate\Support\Collection;

interface ISocialDataService
{
    public function getRepo(): ISocialDataRepository;

    public function getChildNames(SocialData $data): ?string;

    public function regisSocialData(SocialEvent $socialEvent, Collection $insertingSocialData): Collection;

    public function updateProgress(UpdateProgressSocialData $attributes, SocialData $socialData): SocialData;

    public function getDeleteError(SocialData $socialData): ?string;

    public function getOrderedDateDropdown(SocialEvent $socialEvent): Collection;
}
