<?php

namespace App\Repositories\Announcement;

use App\Models\Announcement;
use App\Models\Display;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface IAnnouncementRepository extends RepositoryInterface
{
    public function getPaginateList(): LengthAwarePaginator;

    public function getDetail(Announcement $announcement): Model|QueryBuilder;

    public function findPostingByDisplay(Display $display): Collection;

}
