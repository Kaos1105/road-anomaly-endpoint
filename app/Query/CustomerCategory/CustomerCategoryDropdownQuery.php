<?php

namespace App\Query\CustomerCategory;

use App\Models\CustomerCategory;
use App\Repositories\CustomerCategory\Filter\FilterByGroupUseFlg;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CustomerCategoryDropdownQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = CustomerCategory::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::exact('group_id'),
            AllowedFilter::custom('group_use_classification', new FilterByGroupUseFlg()),
        ]);
    }
}
