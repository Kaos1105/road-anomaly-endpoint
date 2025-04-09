<?php

namespace App\Query\Company;

use App\Http\DTO\QueryParam\CompanyDropdownNegotiationParam;
use App\Models\Company;
use App\Repositories\Company\Filter\FilterByClientCompany;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CompanyDropdownNegotiationQuery extends QueryBuilder
{
    use HasFilter;

    public function __construct(Request $request)
    {
        $query = Company::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::exact('use_classification'),
            AllowedFilter::custom('client_company', new FilterByClientCompany())
        ]);
    }

    public function setFilterParam(CompanyDropdownNegotiationParam $param): static
    {
        $paramArr = $param->toArray();
        $this->allowedFilters->each(function (AllowedFilter $filter) use ($paramArr) {
            $this->setParamValue($filter, $paramArr);
        });

        return $this;
    }

}
