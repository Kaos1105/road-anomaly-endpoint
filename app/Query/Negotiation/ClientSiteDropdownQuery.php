<?php

namespace App\Query\Negotiation;

use App\Http\DTO\QueryParam\ClientSiteDropdownParam;
use App\Models\ClientSite;
use App\Repositories\ClientSite\Filter\FilterHasNegotiation;
use App\Repositories\Negotiation\Filter\FilterByManagementDepartmentIdBelong;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ClientSiteDropdownQuery extends QueryBuilder
{
    use HasFilter;

    public function __construct(Request $request)
    {
        $query = ClientSite::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::exact('use_classification'),
            AllowedFilter::custom('management_department_id', new FilterByManagementDepartmentIdBelong()),
            AllowedFilter::custom('negotiation', new FilterHasNegotiation()),
        ]);
    }

    public function setFilterParam(ClientSiteDropdownParam $param): static
    {
        $paramArr = $param->toArray();
        $this->allowedFilters->each(function (AllowedFilter $filter) use ($paramArr) {
            $this->setParamValue($filter, $paramArr);
        });

        return $this;
    }
}
