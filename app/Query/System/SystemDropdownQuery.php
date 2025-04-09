<?php

namespace App\Query\System;

use App\Models\System;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SystemDropdownQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = System::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::exact('use_classification'),
        ]);
        $this->allowedSorts([
            'display_order',
        ]);
    }
}
