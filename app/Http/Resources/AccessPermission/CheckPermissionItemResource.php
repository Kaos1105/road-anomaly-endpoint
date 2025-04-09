<?php

namespace App\Http\Resources\AccessPermission;

use App\Enums\Common\DateTimeEnum;
use App\Enums\System\OperationFlagEnum;
use App\Helpers\DateTimeHelper;
use App\Http\DTO\AccessPermission\UpdatePermissionData;
use App\Http\Resources\System\SystemRelationResource;
use App\Models\AccessPermission;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform the resource into an array.
 *
 * @mixin AccessPermission
 */
class CheckPermissionItemResource extends EmployeePermissionItemResource
{
    protected bool $canAccess;

    public function toArray(Request $request): array
    {
        $systemAccessible = $this->relationLoaded('system') && isset($this->system->operation_classification)
            && $this->system->operation_classification == OperationFlagEnum::IN_OPERATION;

        return [
            ...parent::toArray($request),
            'is_accessible' => $systemAccessible && $this->canAccess,
        ];
    }

    public function setParams(int $canAccess): self
    {
        $this->canAccess = $canAccess;
        return $this;
    }
}
