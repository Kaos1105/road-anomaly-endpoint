<?php

namespace App\Repositories\FAQ\Filter;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterNotHasQuestionId implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->whereNot('id', $value);
    }
}
