<?php

namespace App\Services\Customer;

use App\Http\DTO\Customer\AffiliatedDropdownData;
use App\Http\Resources\Company\CompanyRelatedResource;
use App\Http\Resources\Department\DepartmentRelatedResource;
use App\Http\Resources\Employee\EmployeeRelatedResource;
use App\Models\Customer;
use App\Repositories\Customer\ICustomerRepository;

class CustomerService implements ICustomerService
{
    public function __construct(
        public ICustomerRepository $customerRepository,
    )
    {
    }

    public function getRepo(): ICustomerRepository
    {
        return $this->customerRepository;
    }

    public function dropdownAffiliated(): AffiliatedDropdownData
    {
        $affiliated = $this->customerRepository->getAll();
        $uniqueResponsibleEmployees = collect();
        $uniqueAccountingDepartments = collect();
        $uniqueDisplayTransfers = collect();

        $affiliated->each(function (Customer $customer) use (&$uniqueResponsibleEmployees, &$uniqueAccountingDepartments, &$uniqueDisplayTransfers) {
            $uniqueResponsibleEmployees->push(EmployeeRelatedResource::make($customer->responsibleEmployee));
            $uniqueAccountingDepartments->push(DepartmentRelatedResource::make($customer->accountingDepartment));
            $uniqueDisplayTransfers->push(CompanyRelatedResource::make($customer->displayTransfer->company));
        });
        return new AffiliatedDropdownData(
            $uniqueResponsibleEmployees->unique('id')->sortBy('display_order')->values(),
            $uniqueAccountingDepartments->unique('id')->sortBy('display_order')->values(),
            $uniqueDisplayTransfers->unique('id')->sortBy('display_order')->values()
        );
    }


    public function getChildNames(Customer $customer): ?string
    {
        $countRelation = $this->customerRepository->checkRelations($customer);
        if ($countRelation->social_data_count > 0) {
            return __('attributes.social_data.table');
        }
        return null;
    }
}
