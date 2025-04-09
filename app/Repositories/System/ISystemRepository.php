<?php

namespace App\Repositories\System;

use App\Models\System;
use App\Query\System\SystemDropdownQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;

interface ISystemRepository extends RepositoryInterface
{
    public function getAuthenticatedSystem(string $code = ''): ?System;

    public function showDetail(System $detail): System;

    public function getPaginateList(): LengthAwarePaginator;

    public function getList(): Collection;

    public function findByQuery(SystemDropdownQuery $query): Collection|array;

    public function checkRelations(System $system): Model|System;

    public function getDataExport(): Collection;

    public function getListSystemManagement(): Collection;

    public function getSystemSortedByDisplayOrder(): Collection;

}
