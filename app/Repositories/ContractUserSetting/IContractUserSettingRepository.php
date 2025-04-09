<?php

namespace App\Repositories\ContractUserSetting;

use App\Models\ContractUserSetting;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface IContractUserSettingRepository extends RepositoryInterface
{
    public function getPaginateList(): LengthAwarePaginator;

    public function findAll(): Collection|array;

    public function showDetail(ContractUserSetting $contractUserSetting): Model|QueryBuilder;


}
