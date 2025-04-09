<?php

namespace App\Http\Resources\Pagination;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\CursorPaginator;
use JsonSerializable;

/**
 * Transform the resource into an array.
 *
 * @mixin   CursorPaginator
 */
class CursorPaginationResource extends ResourceCollection
{
    public function toArray(Request $request): array|Arrayable|JsonSerializable
    {
        return [
            'collection' => $this->collection,
            'pagination' => [
                'next_cursor' => $this->nextCursor()?->encode(),
                'previous_cursor' => $this->previousCursor()?->encode(),
                'count' => $this->count(),
                'perPage' => $this->perPage(),
                'hasMorePages' => $this->hasMorePages(),
            ],
        ];
    }
}
