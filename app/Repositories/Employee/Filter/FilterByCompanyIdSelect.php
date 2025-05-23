<?php

namespace App\Repositories\Employee\Filter;

use App\Enums\Transfer\MajorHistoryEnum;
use App\Models\Transfer;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByCompanyIdSelect implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $latestTransferId = Transfer::select('id')
            ->whereColumn('organization_transfers.employee_id', 'organization_employees.id')
            ->where('organization_transfers.major_history_flg', '=', MajorHistoryEnum::MAJOR_PERSONAL_CHANGES)
            ->orderByDesc('organization_transfers.updated_at')
            ->limit(1);

        return $query->whereHas('transfers', function (Builder $transferQuery) use ($latestTransferId, $value) {
            $transferQuery->where('organization_transfers.id', $latestTransferId)
                ->where('organization_transfers.company_id', $value);
        });
    }
}

