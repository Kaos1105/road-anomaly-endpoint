<?php

namespace App\Repositories\ChatContent;

use App\Models\ChatContent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\CursorPaginator;
use Prettus\Repository\Contracts\RepositoryInterface;

interface IChatContentRepository extends RepositoryInterface
{
    public function getPaginateList(): CursorPaginator;

    public function getPaginatedCursor(): CursorPaginator;

    public function createChatContent(array $chatContent): ChatContent|null;

    public function getChatContentDetail(ChatContent $chatContent): ChatContent;
}
