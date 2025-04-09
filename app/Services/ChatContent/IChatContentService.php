<?php

namespace App\Services\ChatContent;

use App\Repositories\ChatContent\IChatContentRepository;

interface IChatContentService
{
    public function getRepo(): IChatContentRepository;

    public function createChatContentEvent(array $chatContentValue): array;

}
