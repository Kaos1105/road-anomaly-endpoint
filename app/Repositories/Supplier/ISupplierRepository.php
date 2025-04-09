<?php

namespace App\Repositories\Supplier;

use App\Models\SocialEvent;
use App\Models\Supplier;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;

interface ISupplierRepository extends RepositoryInterface
{
    public function getDetail(Supplier $detail): Supplier;

    public function getPaginateList(): LengthAwarePaginator;

    public function numberOfRecords(): int;

    public function getSocialEventSuppliers(SocialEvent $socialEvent): Collection;

    public function getFiveYearTotalOfSupplier(Supplier $supplier): Supplier|null;

    public function getSocialEventSupplierDetail(): Supplier|null;

    public function checkRelations(Supplier $supplier): Model|Supplier;

}
