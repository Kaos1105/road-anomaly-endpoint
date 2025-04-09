<?php

namespace App\Query\Negotiation;

use App\Http\DTO\QueryParam\NegotiationCalendarParam;
use App\Models\Negotiation;
use App\Repositories\Negotiation\Filter\FilterByClientSiteIds;
use App\Repositories\Negotiation\Filter\FilterByMonth;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CalendarQuery extends QueryBuilder
{
    use HasFilter;

    public function __construct(Request $request)
    {
        $query = Negotiation::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::custom('date', new FilterByMonth()),
            AllowedFilter::custom('client_site_ids', new FilterByClientSiteIds()),
        ]);
    }

    public function setFilterParam(NegotiationCalendarParam $param): static
    {
        $paramArr = $param->toArray();
        $this->allowedFilters->each(function (AllowedFilter $filter) use ($paramArr) {
            $this->setParamValue($filter, $paramArr);
        });

        return $this;
    }

}
