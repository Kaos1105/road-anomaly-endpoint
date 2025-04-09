<?php

namespace App\Services\Negotiation;

use App\Models\Negotiation;
use App\Repositories\Negotiation\INegotiationRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface INegotiationService
{
    public function getRepo(): INegotiationRepository;

    public function getPaginateList(): LengthAwarePaginator;

    public function createRecord(array $dataInsert): Negotiation|null;

    public function deleteRecord(Negotiation $negotiation): void;

    public function updateRecord(array $dataUpdate, Negotiation $negotiation): Negotiation|null;

    public function showCalendar(): Collection|null;

}
