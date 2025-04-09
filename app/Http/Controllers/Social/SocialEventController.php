<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\SocialEvent\UpsertSocialEventRequest;
use App\Http\Resources\SocialData\PurchaseOrderedSocialDataCollection;
use App\Http\Resources\SocialEvent\SocialDataEventResource;
use App\Http\Resources\SocialEvent\SocialEventAmountResource;
use App\Http\Resources\SocialEvent\SocialEventCollection;
use App\Http\Resources\SocialEvent\SocialEventDetailResource;
use App\Models\SocialEvent;
use App\Services\SocialData\ISocialDataService;
use App\Services\SocialEvent\ISocialEventService;
use App\Services\Supplier\ISupplierService;

class SocialEventController extends Controller
{
    public function __construct(
        private readonly ISocialEventService $socialEventService,
        private readonly ISocialDataService  $socialDataService,
        private readonly ISupplierService    $supplierService,
    )
    {
    }

    public function index(): ResponseData
    {
        $suppliers = $this->socialEventService->getRepo()->getPaginateList();

        return $this->httpOk(new SocialEventCollection($suppliers));
    }

    public function show(SocialEvent $socialEvent): ResponseData
    {
        $result = $this->socialEventService->getRepo()->showDetail($socialEvent);

        return $this->httpOk(new SocialEventDetailResource($result));
    }

    public function store(UpsertSocialEventRequest $request): ResponseData
    {
        $data = $request->validated();
        $result = $this->socialEventService->getRepo()->create($data);
        $detail = $this->socialEventService->getRepo()->showDetail($result);

        return $this->httpCreated(new SocialEventDetailResource($detail));
    }

    public function update(UpsertSocialEventRequest $request, SocialEvent $socialEvent): ResponseData
    {
        $data = $request->validated();
        $result = $this->socialEventService->getRepo()->update($data, $socialEvent->id);
        $detail = $this->socialEventService->getRepo()->showDetail($result);

        return $this->httpOk(new SocialEventDetailResource($detail));
    }

    public function destroy(SocialEvent $socialEvent): ResponseData
    {
        $childNames = $this->socialEventService->getChildNames($socialEvent);
        if ($childNames) {
            return $this->httpBadRequest(msg: __('errors.can_not_delete', ['attr1' => $childNames]));
        }

        $this->socialEventService->getRepo()->delete($socialEvent->id);

        return $this->httpNoContent();
    }

    public function showSocialDataEventDetail(SocialEvent $socialEvent): ResponseData
    {
        $result = $this->socialEventService->getRepo()->showSocialDataEventDetail($socialEvent);

        return $this->httpOk(new SocialDataEventResource($result));
    }

    public function showSocialEventWithSupplier(SocialEvent $socialEvent): ResponseData
    {
        $result = $this->socialEventService->getRepo()->showSocialEventWithSupplier($socialEvent);
        $supplier = $this->supplierService->getRepo()->getSocialEventSupplierDetail();

        return $this->httpOk((new SocialEventAmountResource($result))->setParams($supplier));
    }

    public function getSocialDataByEvent(SocialEvent $socialEvent): ResponseData
    {
        $result = $this->socialDataService->getRepo()->getPaginateDataBySocialEvent($socialEvent);

        return $this->httpOk(new PurchaseOrderedSocialDataCollection($result));
    }

}
