<?php

namespace App\Services\Dashboard;

use App\Http\DTO\AccessHistory\AccessHistoryCardData;
use App\Http\DTO\Social\SocialEventDashboardData;
use App\Repositories\Customer\ICustomerRepository;
use App\Repositories\EventClassification\IEventClassificationRepository;
use App\Repositories\ManagementGroup\IManagementGroupRepository;
use App\Repositories\SocialEvent\ISocialEventRepository;
use App\Repositories\Supplier\ISupplierRepository;
use App\Repositories\Transfer\ITransferRepository;
use Illuminate\Support\Collection;

readonly class SocialDashboardService implements ISocialDashboardService
{
    public function __construct(
        private ISocialEventRepository         $socialEventRepository,
        private IManagementGroupRepository     $managementGroupRepository,
        private IEventClassificationRepository $eventClassificationRepository,
        private ISupplierRepository            $supplierRepository,
        private ICustomerRepository            $customerRepository,
        private ITransferRepository            $transferRepository,
    )
    {

    }

    public function checkBtnSocialEvent(Collection $socialEventCollection): SocialEventDashboardData
    {
        $numberOfSocialEvents = $this->socialEventRepository->numberOfRecords();
        $numberOfManagementGroups = $numberOfSocialEvents > 0 ? $numberOfSocialEvents : $this->managementGroupRepository->numberOfRecordInUse();
        $numberOfEventClassifications = $numberOfManagementGroups > 0 ? $numberOfManagementGroups : $this->eventClassificationRepository->numberOfRecordInUse();

        return new SocialEventDashboardData($numberOfEventClassifications > 0, $socialEventCollection);
    }

    public function checkBtnSupplier(Collection $supplierCollection): AccessHistoryCardData
    {
        $numberOfSuppliers = $this->supplierRepository->numberOfRecords();
        $numberOfEmployees = $numberOfSuppliers > 0 ? $numberOfSuppliers : $this->transferRepository->getActiveTransferForSupplier()->count();

        return new AccessHistoryCardData($numberOfEmployees > 0, $supplierCollection);
    }

    public function checkBtnCustomer(Collection $customerCollection): AccessHistoryCardData
    {
        $numberOfCustomers = $this->customerRepository->numberOfRecords();
        $numberOfEmployees = $numberOfCustomers > 0 ? $numberOfCustomers : $this->transferRepository->getActiveTransferForCustomer()->count();

        return new AccessHistoryCardData($numberOfEmployees > 0, $customerCollection);
    }

}
