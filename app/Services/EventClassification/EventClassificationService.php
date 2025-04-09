<?php

namespace App\Services\EventClassification;

use App\Models\EventClassification;
use App\Repositories\EventClassification\IEventClassificationRepository;

class EventClassificationService implements IEventClassificationService
{
    public function __construct(
        public IEventClassificationRepository $eventClassificationRepository,
    )
    {
    }

    public function getRepo(): IEventClassificationRepository
    {
        return $this->eventClassificationRepository;
    }

    public function getChildNames(EventClassification $eventClassification): ?string
    {
        $countRelation = $this->eventClassificationRepository->checkRelations($eventClassification);
        if ($countRelation->social_events_count > 0) {
            return __('attributes.social_event.table');
        }
        return null;
    }
}
