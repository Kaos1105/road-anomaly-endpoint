<?php

namespace App\Query\Department;

use App\Models\Department;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class DepartmentDropdownQuery extends QueryBuilder
{
    use HasFilter;
    public function __construct(Request $request)
    {
        $query = Department::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::exact('use_classification'),
            AllowedFilter::exact('site_id')
        ]);
    }

}
