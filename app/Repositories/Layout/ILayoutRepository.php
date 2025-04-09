<?php

namespace App\Repositories\Layout;

use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

interface ILayoutRepository extends RepositoryInterface
{
    public function findLayoutByEmployee(int $systemId, int $employeeId, ?array $contentsNo = null): Collection;

    public function createLayoutEmployee(array $dataInsert): bool;

    public function updateLayoutEmployee(array $dataUpdate): int;

    public function deleteLayoutEmployee(int $systemId, int $employeeId, ?array $contentsNo = null): int;

    public function findLayoutBlock(int $systemId, int $employeeId, string $block, int $blockOrderStart, ?int $blockOrderEnd = null): Collection;

}

