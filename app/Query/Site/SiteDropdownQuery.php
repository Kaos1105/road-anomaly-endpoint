<?php

namespace App\Query\Site;

use App\Models\Site;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SiteDropdownQuery extends QueryBuilder
{

    public function __construct(Request $request)
    {
        $query = Site::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::exact('use_classification'),
            AllowedFilter::exact('company_id')
        ]);
    }
}
