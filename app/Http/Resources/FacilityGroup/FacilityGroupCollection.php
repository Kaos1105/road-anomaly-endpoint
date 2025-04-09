<?php

namespace App\Http\Resources\FacilityGroup;

use App\Http\Resources\Pagination\PaginationResource;

class FacilityGroupCollection extends PaginationResource
{
    public $collects = FacilityGroupItemResource::class;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request = null): array
    {
        return parent::toArray($request);
    }

}
