<?php

namespace App\Repositories\Content;

use App\Models\Content;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

interface IContentRepository extends RepositoryInterface
{
    public function showDetail(Content $detail): Content;

    public function getPaginateList(): LengthAwarePaginator;

    public function getList(): Collection;

    public function getListByDisplay(int $displayId): Collection;

    public function getListCardByDisplay(int $displayId): Collection;

    public function findByScreenContentNo(string $displayCode, string $contentNo): Content|null;

    public function deleteMultiple(array $ids): void;

    public function getDataExport(): Collection;

}
