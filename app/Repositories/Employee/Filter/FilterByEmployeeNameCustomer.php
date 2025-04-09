<?php

namespace App\Repositories\Employee\Filter;

use App\Enums\Transfer\MajorHistoryEnum;
use App\Models\Transfer;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByEmployeeNameCustomer implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $latestTransferId = Transfer::select('id')
            ->whereColumn('organization_transfers.employee_id', 'organization_employees.id')
            ->where('organization_transfers.major_history_flg', '=', MajorHistoryEnum::MAJOR_PERSONAL_CHANGES)
            ->orderByDesc('organization_transfers.updated_at')
            ->limit(1);

        return $query->where(function (Builder $subQuery) use ($value, $latestTransferId) {
            $subQuery->where('organization_employees.last_name', 'LIKE', '%' . $value . '%')
                ->orWhere('organization_employees.first_name', 'LIKE', '%' . $value . '%')
                ->orWhere('organization_employees.kana', 'LIKE', '%' . $value . '%')
                ->orWhere('organization_employees.maiden_name', 'LIKE', '%' . $value . '%')
                ->orWhereHas('transfers', function (Builder $transferQuery) use ($value, $latestTransferId) {
                    $transferQuery->where('organization_transfers.id', $latestTransferId)
                        ->whereHas('company', function ($companyQuery) use ($value) {
                            $companyQuery->where('long_name', 'LIKE', '%' . $value . '%')
                                ->orWhere('short_name', 'LIKE', '%' . $value . '%')
                                ->orWhere('kana', 'LIKE', '%' . $value . '%');
                        });
                });
        });
    }
}
