<?php

namespace App\Repositories\EventClassification;

use App\Models\EventClassification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;

interface IEventClassificationRepository extends RepositoryInterface
{
    public function showDetail(EventClassification $detail): EventClassification;

    public function getList(): Collection;

    public function checkRelations(EventClassification $eventClassification): Model|EventClassification;

    public function numberOfRecordInUse(): int;
}
