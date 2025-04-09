<?php

namespace App\Http\Resources\ChatContent;

use App\Http\Resources\Pagination\CursorPaginationResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Pagination\CursorPaginator;
use JsonSerializable;

/**
 * Transform the resource into an array.
 *
 * @mixin   CursorPaginator
 */
class ChatContentCollectionResource extends CursorPaginationResource
{
    public $collects = ChatContentItemResource::class;

    public function toArray(?Request $request = null): array|JsonSerializable|Arrayable
    {
        return [
            'collection' => $this->collection->sortBy('id')->values(),
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
