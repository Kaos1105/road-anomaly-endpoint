<?php

namespace App\Http\Resources\FAQ;

use App\Models\AccessPermission;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @mixin Question
 */
class QuestionRelatedWithPermissionResource extends JsonResource
{
    protected Collection|null $permissionSimilar;

    public function setParams(Collection $permissionSimilar): self
    {
        $this->permissionSimilar = $permissionSimilar;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var $userPermission AccessPermission
         */
        $userPermission = $this->permissionSimilar->firstWhere('system_id', $this->display?->system_id);
        return [
            'id' => $this->id,
            'code' => $this->code,
            'title' => $this->title,
            'classification' => $this->classification,
            'use_classification' => $this->use_classification,
            'can_access' => ($userPermission && $userPermission->permission_2 >= $this->permission_2 && $userPermission->permission_3 >= $this->permission_3 && $userPermission->permission_4 >= $this->permission_4),
        ];
    }
}
