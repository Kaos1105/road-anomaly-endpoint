<?php

namespace App\Repositories\SocialEvent;

use App\Models\SocialEvent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;

interface ISocialEventRepository extends RepositoryInterface
{
    public function showDetail(SocialEvent $detail): SocialEvent;

    public function getPaginateList(): LengthAwarePaginator;

    public function showSocialEventWithSupplier(SocialEvent $detail): SocialEvent;

    public function checkRelations(SocialEvent $socialEvent): Model|SocialEvent;

    public function numberOfRecords(): int;

    public function getDashboardList(): Collection;
}
