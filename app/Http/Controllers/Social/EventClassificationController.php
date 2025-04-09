<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\EventClassification\UpsertEventClassificationRequest;
use App\Http\Resources\EventClassification\EventClassificationDetailResource;
use App\Http\Resources\EventClassification\EventClassificationRelatedResource;
use App\Models\EventClassification;
use App\Query\EventClassification\EventClassificationDropdownQuery;
use App\Services\EventClassification\IEventClassificationService;

class EventClassificationController extends Controller
{
    public function __construct(private readonly IEventClassificationService $eventClassificationService)
    {
    }

    public function show(EventClassification $eventClassification): ResponseData
    {
        $result = $this->eventClassificationService->getRepo()->showDetail($eventClassification);

        return $this->httpOk(new EventClassificationDetailResource($result));
    }

    public function store(UpsertEventClassificationRequest $request): ResponseData
    {
        $data = $request->validated();
        $result = $this->eventClassificationService->getRepo()->create($data);

        return $this->httpCreated(new EventClassificationDetailResource($result));
    }

    public function update(UpsertEventClassificationRequest $request, EventClassification $eventClassification): ResponseData
    {
        $data = $request->validated();
        $result = $this->eventClassificationService->getRepo()->update($data, $eventClassification->id);

        return $this->httpOk(new EventClassificationDetailResource($result));
    }

    public function destroy(EventClassification $eventClassification): ResponseData
    {
        $childNames = $this->eventClassificationService->getChildNames($eventClassification);
        if ($childNames) {
            return $this->httpBadRequest(msg: __('errors.can_not_delete', ['attr1' => $childNames]));
        }

        $this->eventClassificationService->getRepo()->delete($eventClassification->id);

        return $this->httpNoContent();
    }

    public function dropdownEventClassification(EventClassificationDropdownQuery $query): ResponseData
    {
        $systems = $this->eventClassificationService->getRepo()->findByQuery($query);

        return $this->httpOk(EventClassificationRelatedResource::collection($systems));
    }
}
