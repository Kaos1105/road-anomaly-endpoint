<?php

namespace App\Services\Customer;

use App\Http\DTO\Customer\AffiliatedDropdownData;
use App\Models\Customer;
use App\Repositories\Customer\ICustomerRepository;

interface ICustomerService
{
    public function getRepo(): ICustomerRepository;

    public function dropdownAffiliated(): AffiliatedDropdownData;

    public function getChildNames(Customer $customer): ?string;


}
