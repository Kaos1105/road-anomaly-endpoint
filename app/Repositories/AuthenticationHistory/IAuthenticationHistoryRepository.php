<?php

namespace App\Repositories\AuthenticationHistory;

use App\Models\AuthenticationHistory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface IAuthenticationHistoryRepository extends RepositoryInterface
{
    public function findAll(int $numberRecords): Collection;

    public function getPaginateList(): LengthAwarePaginator;

    public function createData(string $action, string $message, ?int $employeeId): void;

    public function getLastHistory(): QueryBuilder|AuthenticationHistory|null;

    public function countActionEachMonthByYear(string $year): Collection|null;

    public function countActionByYears(array $years): Collection|null;

    public function findTopicDashboard(int $numberRecords): Collection|null;

}
