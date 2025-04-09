<?php

namespace App\Services\AuthenticationHistory;

use App\Http\DTO\AuthenticationHistory\SummaryData;
use App\Repositories\AuthenticationHistory\IAuthenticationHistoryRepository;
use Illuminate\Support\Collection;

interface IAuthenticationHistoryService
{
    public function getRepo(): IAuthenticationHistoryRepository;

    public function getListYears(): array;

    public function getSummary(): SummaryData|null;

    public function getHistoryCard(): Collection|null;
}
