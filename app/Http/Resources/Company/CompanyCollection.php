<?php

namespace App\Http\Resources\Company;

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
class CompanyCollection extends PaginationResource
{
    public $collects = CompanyItemResource::class;

    public function toArray(?Request $request = null): array|JsonSerializable|Arrayable
    {
        return parent::toArray($request);
    }

}
