<?php

namespace App\Http\DTO;

use App\Enums\Common\SortDirectionEnum;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class SortingData extends Data
{
    public static function sortCollection(Collection $collection, array $sortFields): Collection
    {
        $sort = request('sort');
        $descending = str_starts_with($sort, '-');
        $sortColumn = $descending ? substr($sort, 1) : $sort;
        $sortDirection = $descending ? SortDirectionEnum::DESCENDING : SortDirectionEnum::ASCENDING;

        if (in_array($sortColumn, array_keys($sortFields))) {
            return $collection->sortBy([
                [$sortColumn, $sortDirection],
                ...$sortFields[$sortColumn],
            ]);
        } else {
            return $collection->sortBy([
                ...$sortFields[SortDirectionEnum::DEFAULT],
            ]);
        }

    }
}
