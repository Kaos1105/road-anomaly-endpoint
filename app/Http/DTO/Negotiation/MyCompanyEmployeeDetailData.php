<?php

declare(strict_types=1);

namespace App\Http\DTO\Negotiation;

use App\Http\DTO\Common\UserInfoData;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Http\Resources\ManagementDepartment\ManagementDepartmentRelatedResource;
use App\Models\ManagementDepartment;
use App\Models\MyCompanyEmployee;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class MyCompanyEmployeeDetailData extends Data
{
    public function __construct(
        public int                                 $id,
        public int                                 $positionClassification,
        public int                                 $employeeId,
        public EmployeeNameResource                $employee,
        public ?string                             $memo,
        public int                                 $displayOrder,
        public int                                 $useClassification,
        public ?UserInfoData                       $createdInfo,
        public ?UserInfoData                       $updatedInfo,
        public ManagementDepartmentRelatedResource $managementDepartment,
    )
    {

    }

    public static function fromModel(MyCompanyEmployee $myCompanyEmployee, ManagementDepartment $managementDepartment): self
    {
        $managementDepartment->load('department');
        return MyCompanyEmployeeDetailData::from([
            ...$myCompanyEmployee->toArray(),
            'employee' => EmployeeNameResource::make($myCompanyEmployee->employee),
            'created_info' => $myCompanyEmployee->created_by ? UserInfoData::fromData($myCompanyEmployee->createdBy, $myCompanyEmployee->created_at) : null,
            'updated_info' => $myCompanyEmployee->updated_by ? UserInfoData::fromData($myCompanyEmployee->updatedBy, $myCompanyEmployee->updated_at) : null,
            'management_department' => ManagementDepartmentRelatedResource::make($managementDepartment)
        ]);
    }
}
