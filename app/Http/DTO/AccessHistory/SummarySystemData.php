<?php

declare(strict_types=1);

namespace App\Http\DTO\AccessHistory;

use App\Enums\AuthenticationHistory\SummaryTableEnum;
use App\Http\DTO\AuthenticationHistory\ItemCellData;
use App\Http\Resources\System\SystemManagementItemResource;
use App\Models\System;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class SummarySystemData extends Data
{
    public function __construct(
        public ?SystemManagementItemResource $system,
        public ?ItemCellData                 $summary = null,
    )
    {
    }


    public static function mapCollection(Collection $systemCollection, Collection $years, Collection $months, ?Collection $yearAccessHistories, ?Collection $monthAccessHistories): Collection
    {
        // Each action
        $result = collect();
        $monthSystems = $monthAccessHistories?->groupBy('system_id');
        $yearSystems = $yearAccessHistories?->groupBy('system_id');

        $systemCollection->each(function (System $system) use (&$result, $monthSystems, $yearSystems, $months, $years) {
            $monthlyCount = self::calculateMonthly($system, $monthSystems, $months);
            $yearCollection = self::getYearCollection($system, $yearSystems, $years);
            $yearsCount = self::getYearSummary($yearCollection);

            $result->push(new SummarySystemData(SystemManagementItemResource::make($system), ItemCellData::from([...$monthlyCount, ...$yearsCount])));
        });

        // Total
        self::calculateTotal($monthAccessHistories, $yearAccessHistories, $months, $years, $result);

        return $result;
    }

    private static function getYearSummary(Collection $yearCollection): array
    {
        $year = SummarySystemYearData::from($yearCollection->get(SummaryTableEnum::YEAR_KEY));
        $lastYear = SummarySystemYearData::from($yearCollection->get(SummaryTableEnum::LAST_YEAR_KEY));
        $twoYearAgo = SummarySystemYearData::from($yearCollection->get(SummaryTableEnum::TWO_YEAR_AGO_KEY));

        return [
            'year' => $year->accessCount,
            'last_year' => $lastYear->accessCount,
            'two_year_ago' => $twoYearAgo->accessCount,
        ];
    }

    private static function calculateMonthly(System $system, ?Collection $monthSystems, Collection $months): array
    {
        $monthData = $monthSystems?->get($system->id);
        $monthCollection = $monthData ? SummarySystemMonthData::mapCollection($monthData)->merge($months)->unique('month') : $months;

        $monthlyCount = [];
        $monthCollection->each(function (SummarySystemMonthData $item) use (&$monthlyCount) {
            $monthlyCount[$item->month] = $item->accessCount;
        });

        return $monthlyCount;
    }

    private static function getYearCollection(System $system, ?Collection $yearSystems, Collection $years): Collection
    {
        $yearData = $yearSystems?->get($system->id);
        return $yearData ? collect($yearData)->merge($years)->unique('year')->sortByDesc('year') : $years;
    }

    private static function calculateTotal(?Collection $monthAccessHistories, ?Collection $yearAccessHistories, Collection $months, Collection $years, Collection &$result): void
    {
        // Sum month
        $monthTotal = $monthAccessHistories?->groupBy('month')->map(fn($group, $month) => new SummarySystemMonthData($month, $group->sum('access_count')))?->values();
        $totalCollection = $monthTotal->count() > 0 ? $monthTotal->merge($months)->unique('month')->values() : $months;

        $monthTotalCount = [];
        $totalCollection->each(function (SummarySystemMonthData $item) use (&$monthTotalCount) {
            $monthTotalCount[$item->month] = $item->accessCount;
        });

        // Sum 3 years
        $yearTotal = $yearAccessHistories?->groupBy('year')->map(fn($group, $year) => new SummarySystemYearData($year, $group->sum('access_count')))?->values();
        $yearCollection = $yearTotal ? collect($yearTotal)->merge($years)->unique('year')->sortByDesc('year') : $years;

        $yearsCount = self::getYearSummary($yearCollection);
        $result->push(new SummarySystemData(null, ItemCellData::from([...$monthTotalCount, ...$yearsCount])));
    }
}
