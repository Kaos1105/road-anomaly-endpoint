<?php

namespace App\Repositories\Display;

use App\Models\Display;
use App\Query\FAQ\QuestionDropdownQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;

interface IDisplayRepository extends RepositoryInterface
{
    public function showDetail(Display $detail): Display;

    public function findDisplay(int $displayId): Display|null;

    public function findDisplayByCode(string $screenCode, int $isUse = null): Display|null;

    public function getPaginateList(): LengthAwarePaginator;

    public function getList(): Collection;

    public function getListQuestions(QuestionDropdownQuery $query, Collection $userPermission): Collection;

    public function checkRelations(Display $display): Model|Display;

    public function deleteMultiple(array $ids): void;

    public function getDataExport(): Collection;

}
