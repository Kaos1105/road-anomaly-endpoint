<?php

namespace App\Query\Employee;

use App\Http\DTO\QueryParam\UserDropdownParam;
use App\Models\Employee;
use App\Repositories\Employee\Filter\FilterHasLogin;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserDropdownQuery extends QueryBuilder
{
    use HasFilter;

    public function __construct(Request $request)
    {
        $query = Employee::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::custom('has_login', new FilterHasLogin()),
        ]);
    }

    public function setFilterParam(UserDropdownParam $param): static
    {
        $paramArr = $param->toArray();
        $this->allowedFilters->each(function (AllowedFilter $filter) use ($paramArr) {
            $this->setParamValue($filter, $paramArr);
        });

        return $this;
    }
}
