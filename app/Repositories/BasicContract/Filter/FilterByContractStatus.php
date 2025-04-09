<?php

namespace App\Repositories\BasicContract\Filter;

use App\Enums\Contract\ContractStatusEnum;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByContractStatus implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        $now = Carbon::now()->startOfDay();

        switch ($value) {
            case ContractStatusEnum::BEFORE_CONTRACT_START:
                $query->whereHas('individualContracts')
                    ->withCount([
                        'individualContracts as count_start' => function ($query) use ($now) {
                            $query->where('start_date', '>', $now);
                        },
                        'individualContracts as count_total'
                    ])
                    ->havingRaw('count_start = count_total');;
                break;

            case ContractStatusEnum::DURING_CONTRACT:
                $query->whereHas('individualContracts', function (Builder $query) use ($now) {
                    $query->where('start_date', '<=', $now)
                        ->where('end_date', '>=', $now);
                });
                break;

            case ContractStatusEnum::END_CONTRACT:
                $query->whereHas('individualContracts')
                    ->withCount([
                        'individualContracts as count_end' => function ($query) use ($now) {
                            $query->where('end_date', '<', $now);
                        },
                        'individualContracts as count_total'
                    ])
                    ->havingRaw('count_end = count_total');

                break;

            case ContractStatusEnum::UNREGISTERED_CONTRACT_PERIOD:
                $query->whereDoesntHave('individualContracts');
                break;

        }

        return $query;
    }
}
