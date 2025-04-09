<?php

namespace App\Services\Dashboard;

use App\Http\DTO\AccessHistory\AccessHistoryCardData;
use Illuminate\Support\Collection;

interface INegotiationDashboardService
{
    public function checkBtnClientSite(Collection $clientSiteAccessHistory): AccessHistoryCardData;

    public function checkBtnNegotiationHistory(Collection $negotiationAccessHistory): AccessHistoryCardData;

}
