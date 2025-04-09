<?php

namespace App\Query\Company;

use App\Models\Company;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CompanyDropdownQuery extends QueryBuilder
{

    public function __construct(Request $request)
    {
        $query = Company::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::exact('use_classification')
        ]);
    }

}
