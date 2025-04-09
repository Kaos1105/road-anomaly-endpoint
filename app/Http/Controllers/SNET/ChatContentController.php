<?php

namespace App\Http\Controllers\SNET;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\ChatContent\ChatContentInsertRequest;
use App\Http\Resources\ChatContent\ChatContentCollectionResource;
use App\Jobs\SendClientChat;
use App\Services\ChatContent\IChatContentService;
use App\Services\ChatThread\IChatThreadService;

class ChatContentController extends Controller
{
    public function __construct(
        private IChatContentService         $chatContentService,
        private readonly IChatThreadService $chatThreadService
    )
    {
    }

    public function index(): ResponseData
    {
        $result = $this->chatContentService->getRepo()->getPaginateList();

        return $this->httpOk(new ChatContentCollectionResource($result));
    }

    public function store(ChatContentInsertRequest $request): ResponseData
    {
        $data = $request->validated();
        $chatContentCursor = $this->chatContentService->createChatContentEvent($data);
        SendClientChat::dispatch($chatContentCursor);
        $this->chatThreadService->dispatchChatEventToAdmin();

        return $this->httpOk($chatContentCursor);
    }
}
