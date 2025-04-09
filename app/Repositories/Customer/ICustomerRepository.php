<?php

namespace App\Repositories\Customer;

use App\Models\Customer;
use App\Models\SocialEvent;
use App\Query\Customer\SocialDataUnRegisCustomerQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;

interface ICustomerRepository extends RepositoryInterface
{
    public function showDetail(Customer $detail): Customer;

    public function createCustomer(array $dataInsert): Customer;

    public function updateCustomer(array $dataUpdate, Customer $customer): Customer;

    public function getList(): Collection;

    public function getAll(): Collection;

    public function getPaginateList(): LengthAwarePaginator;

    public function numberOfRecords(): int;
    public function getUnRegisCustomers(SocialEvent $socialEvent, SocialDataUnRegisCustomerQuery $query): LengthAwarePaginator;

    public function getRegisteringCustomerSocialData(SocialEvent $socialEvent, array $customerIds): Collection;

    public function checkRelations(Customer $customer): Model|Customer;

}
