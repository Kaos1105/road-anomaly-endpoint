<?php

declare(strict_types=1);

namespace App\Http\DTO\ChatContent;

use App\Http\Resources\ChatContent\ChatContentItemResource;
use App\Http\Resources\Pagination\CursorResource;
use App\Models\ChatContent;
use Illuminate\Http\Request;
use Illuminate\Pagination\CursorPaginator;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class ChatContentWithCursorData extends Data
{
    public function __construct(
        public int   $chatThreadId,
        public array $chatContent,
        public array $pagination,
    )
    {
    }

    public static function mapping(ChatContent $chatContent, CursorPaginator $cursorResource): self
    {
        return new self(
            $chatContent->chat_thread_id,
            (new ChatContentItemResource($chatContent))->toArray(request()),
            (new CursorResource($cursorResource))->toArray(request()),);
    }
}
