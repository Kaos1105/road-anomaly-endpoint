<?php

namespace App\Http\Controllers\SNET;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\Announcement\UpsertAnnouncementRequest;
use App\Http\Resources\Announcement\AnnouncementCollectionResource;
use App\Http\Resources\Announcement\AnnouncementDetailResource;
use App\Models\Announcement;
use App\Services\Announcement\IAnnouncementService;

class AnnouncementController extends Controller
{
    public function __construct(
        private readonly IAnnouncementService $announcementService,
    )
    {
    }

    public function index(): ResponseData
    {
        $announcements = $this->announcementService->getRepo()->getPaginateList();

        return $this->httpOk(new AnnouncementCollectionResource($announcements));
    }

    public function show(Announcement $announcement): ResponseData
    {
        $announcement = $this->announcementService->getRepo()->getDetail($announcement);

        return $this->httpOk(new AnnouncementDetailResource($announcement));
    }

    public function update(UpsertAnnouncementRequest $request, Announcement $announcement): ResponseData
    {
        $dataRequest = $request->validated();
        $data = $this->announcementService->getRepo()->update($dataRequest, $announcement->id);
        $announcement = $this->announcementService->getRepo()->getDetail($data);

        return $this->httpOk(new AnnouncementDetailResource($announcement));
    }

    public function store(UpsertAnnouncementRequest $request): ResponseData
    {
        $dataRequest = $request->validated();

        $data = $this->announcementService->getRepo()->create($dataRequest);
        $announcement = $this->announcementService->getRepo()->getDetail($data);

        return $this->httpOk(new AnnouncementDetailResource($announcement));
    }

    public function destroy(Announcement $announcement): ResponseData
    {
        $this->announcementService->getRepo()->delete($announcement->id);

        return $this->httpOk();
    }

    public function getDisplayPosting(): ResponseData
    {
        $posting = $this->announcementService->getPostingByDisplayCode();
        return $this->httpOk($posting);

    }
}
