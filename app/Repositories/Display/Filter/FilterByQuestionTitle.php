<?php

namespace App\Repositories\Display\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByQuestionTitle implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->whereHas('questions', function (EloquentBuilder $questionQuery) use ($value) {
            $questionQuery->where('title','LIKE', '%'. $value . '%');
        });
    }
}
