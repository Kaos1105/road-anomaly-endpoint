<?php

namespace App\Services\EventClassification;

use App\Models\EventClassification;
use App\Repositories\EventClassification\IEventClassificationRepository;

interface IEventClassificationService
{
    public function getRepo(): IEventClassificationRepository;

    public function getChildNames(EventClassification $eventClassification): ?string;
}
