<?php

namespace App\Query\Negotiation;

use App\Http\DTO\QueryParam\ClientEmployeeDropdownParam;
use App\Models\ClientEmployee;
use App\Repositories\ClientEmployee\Filter\FilterByClientSiteId;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ClientEmployeeDropdownQuery extends QueryBuilder
{
    use HasFilter;

    public function __construct(Request $request)
    {
        $query = ClientEmployee::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::exact('use_classification'),
            AllowedFilter::custom('client_site_id', new FilterByClientSiteId()),
        ]);
    }

    public function setFilterParam(ClientEmployeeDropdownParam $param): static
    {
        $paramArr = $param->toArray();
        $this->allowedFilters->each(function (AllowedFilter $filter) use ($paramArr) {
            $this->setParamValue($filter, $paramArr);
        });

        return $this;
    }
}
