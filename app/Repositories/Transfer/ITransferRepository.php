<?php

namespace App\Repositories\Transfer;

use App\Enums\Company\CompanyClassificationEnum;
use App\Models\Employee;
use App\Models\Transfer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface ITransferRepository extends RepositoryInterface
{
    public function getPaginateList(): LengthAwarePaginator;

    public function findAll(): Collection|array;

    public function showDetail(Transfer $transfer): Model|QueryBuilder;

    public function getTransfersByEmployee(Employee $employee): Collection|array;

    public function setRepresentativeTransfer(Transfer $transfer, array $dataUpdate): void;

    public function getTransfersByEmployeeSocial(Employee $employee): Collection|array;

    public function checkRelations(Transfer $transfer): Model|Transfer;

    public function getActiveTransferForCustomer(): Collection;

    public function getActiveTransferForSupplier(): Collection;

}
