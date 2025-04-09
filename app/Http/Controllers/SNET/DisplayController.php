<?php

namespace App\Http\Controllers\SNET;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\ScreenName\DisplayUpdateRequest;
use App\Http\Resources\Display\DisplayDetailResource;
use App\Http\Resources\Display\DisplayItemSystemResource;
use App\Http\Resources\Display\ScreenNameItemResource;
use App\Http\Resources\FAQ\QuestionItemResource;
use App\Models\Display;
use App\Services\Display\IDisplayService;
use App\Services\FAQ\IQuestionService;

class DisplayController extends Controller
{
    public function __construct(
        private readonly IDisplayService  $displayService,
        private readonly IQuestionService $questionService,
    )
    {
    }

    public function getAllScreens(): ResponseData
    {
        $screens = $this->displayService->getList();

        return $this->httpOk(ScreenNameItemResource::collection($screens));
    }

    public function show(Display $display): ResponseData
    {
        $result = $this->displayService->getRepo()->showDetail($display);
        return $this->httpOk((new DisplayDetailResource($result)));
    }

    public function update(DisplayUpdateRequest $request, Display $display): ResponseData
    {
        $data = $request->validated();
        $result = $this->displayService->getRepo()->update($data, $display->id);
        return $this->httpOk(new DisplayDetailResource($result));
    }

    public function getAllQuestions(Display $display): ResponseData
    {
        $result = $this->questionService->getList($display);
        return $this->httpOk(QuestionItemResource::collection($result));
    }

    public function store(DisplayUpdateRequest $request): ResponseData
    {
        $data = $request->validated();
        $result = $this->displayService->getRepo()->create($data);
        return $this->httpOk(new DisplayDetailResource($result));
    }

    public function destroy(Display $display): ResponseData
    {
        $childNames = $this->displayService->getChildNames($display);
        if ($childNames) {
            return $this->httpBadRequest(msg: __('errors.can_not_delete', ['attr1' => $childNames]));
        }
        $this->displayService->deleteRecord($display);

        return $this->httpOk();
    }

    public function getDisplaysBySystem(int $systemId): ResponseData
    {
        $result = $this->displayService->getDisplaysForDropdown($systemId);

        return $this->httpOk(DisplayItemSystemResource::collection($result));
    }
}
