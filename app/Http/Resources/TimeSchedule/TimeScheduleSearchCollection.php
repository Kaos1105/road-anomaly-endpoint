<?php

namespace App\Http\Resources\TimeSchedule;

use App\Http\Resources\Pagination\PaginationResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use JsonSerializable;

/**
 * Transform the resource into an array.
 *
 * @mixin   LengthAwarePaginator
 */
class TimeScheduleSearchCollection extends PaginationResource
{
    public $collects = TimeScheduleSearchItemResource::class;

    public function toArray(?Request $request = null): array|JsonSerializable|Arrayable
    {
        return parent::toArray($request);
    }

}
