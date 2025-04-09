<?php

declare(strict_types=1);

namespace App\Http\DTO\AccessHistory;

use App\Http\Resources\Company\CompanyRelatedResource;
use App\Http\Resources\Department\DepartmentRelatedResource;
use App\Http\Resources\Division\DivisionRelatedResource;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Models\AccessHistory;
use App\Models\Transfer;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class AccessHistoryEmployeeData extends Data
{
    public function __construct(
        public int                        $id,
        public int                        $systemId,
        public string                     $action,
        public string                     $resultClassification,
        public string                     $accessibleType,
        public int                        $employeeId,
        public int                        $accessibleId,
        public ?string                    $message,
        public string                     $accessAt,
        public ?EmployeeNameResource      $employee,
        public ?EmployeeNameResource      $accessibleEmployee,
        public ?CompanyRelatedResource    $company,
        public ?DepartmentRelatedResource $department,
        public ?DivisionRelatedResource   $division
    )
    {

    }

    public static function mapCollection(Collection $collection, bool $isShinichiro = false): Collection
    {
        return $collection->map(function (AccessHistory $accessHistory) use ($isShinichiro) {

            /**
             * @var $transfer Transfer
             */
            $transfer = $accessHistory?->accessible?->transfers->first();
            $relatedInfo = [
                'employee' => $accessHistory->relationLoaded('employee') && $accessHistory->employee ? EmployeeNameResource::make($accessHistory->employee) : null,
                'accessible_employee' => $transfer && $transfer->relationLoaded('employee') && $transfer->employee ? EmployeeNameResource::make($transfer->employee) : null,
                'company' => $transfer && $transfer->relationLoaded('company') && $transfer->company ? CompanyRelatedResource::make($transfer->company) : null,
            ];
            if ($isShinichiro) {
                $relatedInfo = [
                    ...$relatedInfo,
                    'department' => $transfer && $transfer->relationLoaded('department') && $transfer->department ? DepartmentRelatedResource::make($transfer->department) : null,
                    'division' => $transfer && $transfer->relationLoaded('division') && $transfer->division ? DivisionRelatedResource::make($transfer->division) : null,
                ];
            }
            return AccessHistoryEmployeeData::from([
                ...$accessHistory->toArray(),
                ...$relatedInfo
            ]);
        });
    }
}
