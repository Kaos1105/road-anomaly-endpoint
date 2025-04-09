<?php

namespace App\Query\FAQ;

use App\Http\DTO\QueryParam\DisplayDropdownParam;
use App\Models\Display;
use App\Repositories\Display\Filter\FilterByQuestionTitle;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class QuestionDropdownQuery extends QueryBuilder
{
    use HasFilter;

    public function __construct(Request $request)
    {
        $query = Display::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::exact('id'),
            AllowedFilter::exact('system_id'),
            AllowedFilter::custom('search', new FilterByQuestionTitle()),
        ]);
    }

    public function setFilterParam(DisplayDropdownParam $param): static
    {
        $paramArr = $param->toArray();
        $this->allowedFilters->each(function (AllowedFilter $filter) use ($paramArr) {
            $this->setParamValue($filter, $paramArr);
        });

        return $this;
    }
}
