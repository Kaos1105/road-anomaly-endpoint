<?php

namespace App\Query\Product;

use App\Models\Product;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SocialDataProductQuery extends QueryBuilder
{
    use HasFilter;

    public function __construct(Request $request)
    {
        $query = Product::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::exact('use_classification'),
        ]);
    }

    public function setFilterParam(array $paramArr): static
    {
        $this->allowedFilters->each(function (AllowedFilter $filter) use ($paramArr) {
            $this->setParamValue($filter, $paramArr);
        });

        return $this;
    }
}
