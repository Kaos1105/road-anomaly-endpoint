<?php

namespace App\Services\Company;

use App\Models\Company;
use App\Query\Company\CompanyDropdownQuery;
use App\Repositories\Company\ICompanyRepository;
use Illuminate\Support\Collection;

interface ICompanyService
{
    public function getRepo(): ICompanyRepository;

    public function getChildNames(Company $company): ?string;

    public function deleteRecord(Company $company): void;

    public function getCompanySupplier(CompanyDropdownQuery $query): Collection|array;

    public function getCompanyContractDropdown(): Collection|array;
}
