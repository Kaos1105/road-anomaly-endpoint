<?php

namespace App\Http\Controllers\SNET;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\ScreenName\ContentUpdateRequest;
use App\Http\Resources\Display\Content\ContentDetailResource;
use App\Http\Resources\Display\Content\ContentItemResource;
use App\Models\Content;
use App\Services\Content\IContentService;

class ContentController extends Controller
{
    public function __construct(
        private readonly IContentService $contentService,
    )
    {
    }

    public function index(): ResponseData
    {
        $contents = $this->contentService->getList();

        return $this->httpOk(ContentItemResource::collection($contents));
    }

    public function show(Content $content): ResponseData
    {
        $result = $this->contentService->getRepo()->showDetail($content);
        return $this->httpOk((new ContentDetailResource($result)));
    }

    public function update(ContentUpdateRequest $request, Content $content): ResponseData
    {
        $data = $request->validated();
        $result = $this->contentService->getRepo()->update($data, $content->id);
        return $this->httpOk(new ContentDetailResource($result));
    }

    public function store(ContentUpdateRequest $request): ResponseData
    {
        $data = $request->validated();
        $result = $this->contentService->getRepo()->create($data);
        return $this->httpOk(new ContentDetailResource($result));
    }

    public function destroy(Content $content): ResponseData
    {

        $this->contentService->getRepo()->delete($content->id);

        return $this->httpOk();
    }
}
