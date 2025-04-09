<?php

namespace App\Services\Company;

use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Enums\Contract\CompanyEnum;
use App\Helpers\FileHelper;
use App\Models\Company;
use App\Query\Company\CompanyDropdownQuery;
use App\Repositories\Company\ICompanyRepository;
use BenSampo\Enum\Exceptions\InvalidEnumKeyException;
use DB;
use Illuminate\Support\Collection;
use Throwable;

readonly class CompanyService implements ICompanyService
{
    public function __construct(
        private ICompanyRepository $companyRepository,
    )
    {
    }

    public function getRepo(): ICompanyRepository
    {
        return $this->companyRepository;
    }

    public function getChildNames(Company $company): ?string
    {
        $countRelation = $this->companyRepository->checkRelations($company);
        if ($countRelation->employees_count > 0) {
            return __('attributes.employee.table');
        }
        if ($countRelation->sites_count > 0) {
            return __('attributes.site.table');
        }
        return null;
    }

    /**
     * @throws InvalidEnumKeyException
     * @throws Throwable
     */
    public function deleteRecord(Company $company): void
    {
        DB::transaction(function () use ($company) {
            if (count($company->attachmentFiles) > 0) {
                FileHelper::deleteAttachmentFiles($company->attachmentFiles, AccessibleTypeEnum::COMPANY);
            }
            $company->favorites()->delete();
            $company->delete();
        });
    }

    public function getCompanySupplier(CompanyDropdownQuery $query): array|Collection
    {
        return $this->companyRepository->getCompanySupplier($query);
    }

    public function getCompanyContractDropdown(): Collection|array
    {
        $filter = request('filter');
        $isCounterparty = false;
        if ($filter && $filter['is_counterparty']) {
            $isCounterparty = true;
        }

        return $this->companyRepository->getCompanyContractDropdown($isCounterparty);
    }

}
