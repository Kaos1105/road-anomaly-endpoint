<?php

namespace App\Services\Dashboard;

use App\Http\DTO\AccessHistory\AccessHistoryCardData;
use App\Http\DTO\Social\SocialEventDashboardData;
use Illuminate\Support\Collection;

interface ISocialDashboardService
{
    public function checkBtnSocialEvent(Collection $socialEventCollection): SocialEventDashboardData;

    public function checkBtnSupplier(Collection $supplierCollection): AccessHistoryCardData;

    public function checkBtnCustomer(Collection $customerCollection): AccessHistoryCardData;
}
