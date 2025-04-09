<?php

namespace App\Http\Resources\Company;

use App\Models\Company;
use Illuminate\Http\Request;

/**
 * @mixin Company
 */
class CompanyShortNameResource extends CompanyRelatedResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...parent::toArray($request),
            'short_name' => $this->short_name,
        ];
    }
}
