<?php

namespace App\Repositories\SocialData;

use App\Models\Customer;
use App\Models\SocialData;
use App\Models\SocialEvent;
use App\Models\Workflow;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

interface ISocialDataRepository extends RepositoryInterface
{
    public function showEditDetail(SocialData $detail): SocialData;

    public function getShippingInfo(SocialData $detail): SocialData;

    public function showDisplayDetail(SocialData $detail): SocialData;

    public function getPaginateList(): LengthAwarePaginator;

    public function getSocialDataByCustomer(Customer $customer): Collection;

    public function getLatestNonPendingWorkflow(SocialData $socialData): Workflow|null;

    public function getSocialEventOrderedDate(SocialEvent $socialEvent): Collection;

    public function getPaginateDataBySocialEvent(SocialEvent $socialEvent): LengthAwarePaginator;

    public function getMajorTransfers(SocialData $detail): Collection;

    public function getPaidSocialDataPastThreeYears(): Collection;

    public function getDashboardList(): Collection;
}
