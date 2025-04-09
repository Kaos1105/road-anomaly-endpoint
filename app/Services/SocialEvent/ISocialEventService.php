<?php

namespace App\Services\SocialEvent;

use App\Models\SocialEvent;
use App\Repositories\SocialEvent\ISocialEventRepository;

interface ISocialEventService
{
    public function getRepo(): ISocialEventRepository;

    public function getChildNames(SocialEvent $socialEvent): ?string;
}
