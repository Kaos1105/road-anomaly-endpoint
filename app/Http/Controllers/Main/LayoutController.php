<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\DTO\Layout\DashboardLayoutData;
use App\Http\DTO\ResponseData;
use App\Http\Requests\Layout\LayoutDragDropRequest;
use App\Services\Layout\ILayoutService;

class LayoutController extends Controller
{
    public function __construct(public ILayoutService $layoutService)
    {
    }

    public function getLayout(): ResponseData
    {
        $layout = $this->layoutService->getLayoutDashboard();
        return $this->httpOk(DashboardLayoutData::fromCollection($layout));
    }

    public function dragDropCard(LayoutDragDropRequest $request): ResponseData
    {
        $data = $request->validated();
        $layout = $this->layoutService->dragDropLayoutDashboard($data);
        return $this->httpOk(DashboardLayoutData::fromCollection($layout));
    }
}
