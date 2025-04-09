<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\Customer\UpdateOrderCustomerRequest;
use App\Http\Requests\Customer\UpsertCustomerRequest;
use App\Http\Resources\Customer\CustomerCollection;
use App\Http\Resources\Customer\CustomerDetailResource;
use App\Http\Resources\Customer\RegistrableCustomerCollection;
use App\Http\Resources\Customer\UpdateOrderCustomerResource;
use App\Http\Resources\CustomerCategory\CustomerCategoryItemResource;
use App\Http\Resources\Department\DepartmentDropdownResource;
use App\Models\Customer;
use App\Models\SocialEvent;
use App\Query\Customer\SocialDataUnRegisCustomerQuery;
use App\Services\Customer\ICustomerService;
use App\Services\Department\IDepartmentService;
use App\Services\ManagementGroup\IManagementGroupService;

class CustomerController extends Controller
{
    public function __construct(
        private readonly ICustomerService        $customerService,
        private readonly IManagementGroupService $managementGroupService,
        private readonly IDepartmentService      $departmentService,
    )
    {
    }

    public function dropdownCustomerCategory(): ResponseData
    {
        $managementGroups = $this->managementGroupService->getRepo()->dropdownCustomerCategory();

        return $this->httpOk(CustomerCategoryItemResource::collection($managementGroups));
    }

    public function dropdownShinnichiroDepartment(): ResponseData
    {
        $managementGroups = $this->departmentService->getRepo()->dropdownShinnichiroDepartment();

        return $this->httpOk(DepartmentDropdownResource::collection($managementGroups));
    }

    public function dropdownAffiliated(): ResponseData
    {
        $result = $this->customerService->dropdownAffiliated();
        return $this->httpOk($result->toArray());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpsertCustomerRequest $request): ResponseData
    {
        $data = $request->validated();
        $result = $this->customerService->getRepo()->createCustomer($data);
        return $this->httpCreated(CustomerDetailResource::make($result));
    }

    public function show(Customer $customer): ResponseData
    {
        $result = $this->customerService->getRepo()->showDetail($customer);
        return $this->httpOk(CustomerDetailResource::make($result));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpsertCustomerRequest $request, Customer $customer): ResponseData
    {
        $data = $request->validated();
        $result = $this->customerService->getRepo()->updateCustomer($data, $customer);
        return $this->httpOk(CustomerDetailResource::make($result));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateOrder(UpdateOrderCustomerRequest $request, Customer $customer): ResponseData
    {
        $data = $request->validated();
        $result = $this->customerService->getRepo()->update($data, $customer->id);

        return $this->httpOk(UpdateOrderCustomerResource::make($result));
    }

    public function destroy(Customer $customer): ResponseData
    {
        $childNames = $this->customerService->getChildNames($customer);
        if ($childNames) {
            return $this->httpBadRequest(msg: __('errors.can_not_delete', ['attr1' => $childNames]));
        }
        $this->customerService->getRepo()->delete($customer->id);
        return $this->httpNoContent();
    }


    public function index(): ResponseData
    {
        $customers = $this->customerService->getRepo()->getPaginateList();
        return $this->httpOk(new CustomerCollection($customers));
    }

    public function getUnRegisCustomers(SocialEvent $socialEvent, SocialDataUnRegisCustomerQuery $query): ResponseData
    {
        $customers = $this->customerService->getRepo()->getUnRegisCustomers($socialEvent, $query);

        return $this->httpOk(new RegistrableCustomerCollection($customers));
    }
}
