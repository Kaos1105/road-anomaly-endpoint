<?php

namespace App\Query\Employee;

use App\Models\Employee;
use App\Repositories\Employee\Filter\FilterSupplierSiteId;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class EmployeeSupplierQuery extends QueryBuilder
{
    use HasFilter;

    public function __construct(Request $request)
    {
        $query = Employee::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::custom('store_site_id', new FilterSupplierSiteId()),
        ]);
    }
}
