<?php

declare(strict_types=1);

namespace App\Http\DTO\AccessHistory;

use App\Http\Resources\Employee\EmployeeNameResource;
use App\Models\AccessHistory;
use App\Models\Employee;
use App\Models\System;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class SummaryUserItemData extends Data
{
    public function __construct(
        public ?EmployeeNameResource $employee,
        public ?object               $summary = null,
    )
    {
    }

    public static function mapCollection(Collection $defaultSystems, Collection $employeeCollection, Collection $systemCollection, ?Collection $dataCollection): Collection
    {
        // Each employee
        $employeesData = $dataCollection->groupBy('employee_id');

        $result = collect();
        $employeeCollection->each(function (Employee $employee) use (&$result, $employeesData, $defaultSystems, $systemCollection) {

            $employeeAccessHistories = $employeesData?->get($employee->id)?->values();

            $systemData = self::calculateSystemsByEmployee($employeeAccessHistories, $systemCollection);
            $summary = self::getTotalColumn($systemData, $defaultSystems);

            $result->push(new SummaryUserItemData(EmployeeNameResource::make($employee), $summary));
        });

        //Total
        $systemsData = self::calculateSystemsData($dataCollection, $systemCollection);
        $summary = self::getTotalColumn($systemsData, $defaultSystems);

        $result->push(new SummaryUserItemData(null, $summary));

        return $result;
    }

    private static function getTotalColumn(?Collection $systemData, Collection $defaultSystems): Collection
    {
        $uniqueItems = $systemData ? $systemData->merge($defaultSystems)->unique('code') : $defaultSystems;
        $totalValue = $uniqueItems->sum(fn(SummaryUserSystemData $item) => $item->value);

        $uniqueItems->push(new SummaryUserSystemData('TOTAL', $totalValue));

        return $uniqueItems->mapWithKeys(fn(SummaryUserSystemData $item) => [$item->code => $item->value]);
    }

    private static function calculateSystemsByEmployee(?Collection $employeeAccessHistories, Collection $systemCollection): ?Collection
    {
        return $employeeAccessHistories?->map(function (AccessHistory $systemAccess) use ($systemCollection) {
            /**
             * @var System $system
             */
            $system = $systemCollection?->firstWhere('id', $systemAccess->system_id);
            return new SummaryUserSystemData($system->code, $systemAccess->access_count ?? 0);
        });
    }

    private static function calculateSystemsData(Collection $dataCollection, Collection $systemCollection): Collection
    {
        return $dataCollection->groupBy('system_id')->map(function (Collection $items, $key) use ($systemCollection) {
            /**
             * @var System $system
             */
            $system = $systemCollection?->firstWhere('id', $key);
            $totalValue = $items->sum(fn(AccessHistory $item) => $item->access_count);
            return new SummaryUserSystemData($system->code, $totalValue ?? 0);
        });
    }
}
