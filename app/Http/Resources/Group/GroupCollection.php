<?php

namespace App\Http\Resources\Group;

use App\Http\Resources\Pagination\PaginationResource;

class GroupCollection extends PaginationResource
{
    public $collects = GroupItemResource::class;

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
