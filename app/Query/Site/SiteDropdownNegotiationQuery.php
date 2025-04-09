<?php

namespace App\Query\Site;

use App\Http\DTO\QueryParam\SiteDropdownNegotiationParam;
use App\Models\Site;
use App\Repositories\Site\Filter\FilterExcludeSiteByManagementDepartmentId;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SiteDropdownNegotiationQuery extends QueryBuilder
{
    use HasFilter;

    public function __construct(Request $request)
    {
        $query = Site::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::exact('use_classification'),
            AllowedFilter::exact('company_id'),
            AllowedFilter::custom('exclude_site_by_management_department_id', new FilterExcludeSiteByManagementDepartmentId())
        ]);
    }

    public function setFilterParam(SiteDropdownNegotiationParam $param): static
    {
        $paramArr = $param->toArray();
        $this->allowedFilters->each(function (AllowedFilter $filter) use ($paramArr) {
            $this->setParamValue($filter, $paramArr);
        });

        return $this;
    }
}
