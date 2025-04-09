<?php

namespace App\Services\SocialEvent;

use App\Models\SocialEvent;
use App\Repositories\SocialEvent\ISocialEventRepository;

class SocialEventService implements ISocialEventService
{
    public function __construct(
        public ISocialEventRepository $socialEventRepository,
    )
    {
    }

    public function getRepo(): ISocialEventRepository
    {
        return $this->socialEventRepository;
    }

    public function getChildNames(SocialEvent $socialEvent): ?string
    {
        $countRelation = $this->socialEventRepository->checkRelations($socialEvent);
        if ($countRelation->social_data_count > 0) {
            return __('attributes.social_event.relationship_data');
        }
        return null;
    }
}
