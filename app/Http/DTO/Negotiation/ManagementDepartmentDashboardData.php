<?php

declare(strict_types=1);

namespace App\Http\DTO\Negotiation;

use App\Http\Resources\ManagementDepartment\ManagementDepartmentDropdownResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class ManagementDepartmentDashboardData extends Data
{
    public function __construct(
        public ?AnonymousResourceCollection $managementDepartments,
        public bool                         $canAccessNegotiationHistory = false,
        public ?string                      $message = null,
    )
    {

    }

    /**
     * @param Collection|null $managementDepartmentEmployees
     * @param int|null $clientSiteCount
     * @return ManagementDepartmentDashboardData
     */
    public static function fromData(?Collection $managementDepartmentEmployees, ?int $clientSiteCount): ManagementDepartmentDashboardData
    {
        $isAccess = (count($managementDepartmentEmployees) > 0 && $clientSiteCount) > 0;
        return ManagementDepartmentDashboardData::from([
            'management_departments' => ManagementDepartmentDropdownResource::collection($managementDepartmentEmployees),
            'can_access_negotiation_history' => $isAccess,
            'message' => $isAccess ? null : __('message.negotiation.can_not_access_history')
        ]);
    }
}
