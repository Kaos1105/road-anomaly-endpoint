<?php

namespace App\Http\Resources\Department;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Department
 */
class DepartmentDropdownResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'long_name' => $this->long_name,
            'previous_name' => $this->previous_name,
            'previous_name_flg' => $this->previous_name_flg,
        ];
    }
}
