<?php

namespace App\Repositories\Display\Filter;

use App\Enums\ScreenName\CommonScreenEnum;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByCommonScreenCode implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if ($value) {
            $query->orWhereIn('code', CommonScreenEnum::getValues());
        }
    }
}
