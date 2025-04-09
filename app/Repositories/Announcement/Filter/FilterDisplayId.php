<?php

namespace App\Repositories\Announcement\Filter;

use App\Enums\Common\UnsetValueEnum;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterDisplayId implements Filter
{
    public function __invoke(Builder $query, $value, string $property): void
    {
        if ((int)$value === UnsetValueEnum::NONE) {
            $query->whereNull($property);
        } else {
            $query->where($property, $value);
        }
    }
}
