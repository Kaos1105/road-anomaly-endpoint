<?php

namespace App\Query\Division;

use App\Models\Division;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class DivisionDropdownQuery extends QueryBuilder
{

    public function __construct(Request $request)
    {
        $query = Division::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::exact('use_classification'),
            AllowedFilter::exact('department_id')
        ]);
    }

}
