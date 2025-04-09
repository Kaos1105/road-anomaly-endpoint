<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\DTO\SocialData\RegisSocialData;
use App\Http\DTO\SocialData\UpdateProgressSocialData;
use App\Http\Requests\SocialData\RegisSocialDataRequest;
use App\Http\Requests\SocialData\UpdateDataProgressRequest;
use App\Http\Requests\SocialData\UpdateSocialDataRequest;
use App\Http\Resources\SocialData\CustomerSocialDataResource;
use App\Http\Resources\SocialData\OrderDateResource;
use App\Http\Resources\SocialData\ShippingInfoSocialDataResource;
use App\Http\Resources\SocialData\SocialDataBasicResource;
use App\Http\Resources\SocialData\SocialDataCollection;
use App\Http\Resources\SocialData\SocialDataDetail;
use App\Http\Resources\SocialData\SocialDataEditDetail;
use App\Http\Resources\SocialData\SocialDataWorkflowDetail;
use App\Http\Resources\Transfer\TransferItemByEmployeeResource;
use App\Models\Customer;
use App\Models\SocialData;
use App\Models\SocialEvent;
use App\Services\SocialData\ISocialDataService;

class SocialDataController extends Controller
{
    public function __construct(private readonly ISocialDataService $socialDataService)
    {
    }

    public function index(): ResponseData
    {
        $result = $this->socialDataService->getRepo()->getPaginateList();

        return $this->httpOk(new SocialDataCollection($result));
    }

    public function editDetail(SocialData $socialData): ResponseData
    {
        $result = $this->socialDataService->getRepo()->showEditDetail($socialData);

        return $this->httpOk(new SocialDataEditDetail($result));
    }

    public function getShippingInfo(SocialData $socialData): ResponseData
    {
        $result = $this->socialDataService->getRepo()->getShippingInfo($socialData);

        return $this->httpOk((new ShippingInfoSocialDataResource($result)));
    }

    public function show(SocialData $socialDatum): ResponseData
    {
        $result = $this->socialDataService->getRepo()->showDisplayDetail($socialDatum);

        return $this->httpOk(new SocialDataDetail($result));
    }

    public function workflowDetail(SocialData $socialData): ResponseData
    {
        $result = $this->socialDataService->getRepo()->showDisplayDetail($socialData);

        return $this->httpOk(new SocialDataWorkflowDetail($result));
    }

    public function getMajorTransfers(SocialData $socialData): ResponseData
    {
        $result = $this->socialDataService->getRepo()->getMajorTransfers($socialData);

        return $this->httpOk(TransferItemByEmployeeResource::collection($result));
    }

    public function regisCustomer(RegisSocialDataRequest $request, SocialEvent $socialEvent): ResponseData
    {
        $data = $request->validated();
        $socialData = collect(RegisSocialData::collect($data['social_social_datas']));

        $result = $this->socialDataService->regisSocialData($socialEvent, $socialData);

        return $this->httpOk(SocialDataBasicResource::collection($result));
    }

    public function getSocialDataByCustomer(Customer $customer): ResponseData
    {
        $result = $this->socialDataService->getRepo()->getSocialDataByCustomer($customer);

        return $this->httpOk(CustomerSocialDataResource::collection($result));
    }

    public function update(UpdateSocialDataRequest $request, SocialData $socialDatum): ResponseData
    {
        $data = $request->validated();
        $result = $this->socialDataService->getRepo()->update($data, $socialDatum->id);

        return $this->httpOk(new SocialDataBasicResource($result));
    }

    public function updateDataProgress(UpdateDataProgressRequest $request, SocialData $socialData): ResponseData
    {
        $data = $request->validated();
        $result = $this->socialDataService->updateProgress(UpdateProgressSocialData::from($data), $socialData);

        return $this->httpOk(new SocialDataBasicResource($result));
    }

    public function destroy(SocialData $socialDatum): ResponseData
    {
        $errorMsg = $this->socialDataService->getDeleteError($socialDatum);
        if ($errorMsg) {
            return $this->httpBadRequest(msg: __('errors.social_data_cant_delete'));
        }
        $this->socialDataService->getRepo()->delete($socialDatum->id);
        return $this->httpNoContent();
    }

    public function getOrderedDate(SocialEvent $socialEvent): ResponseData
    {
        $result = $this->socialDataService->getOrderedDateDropdown($socialEvent);

        return $this->httpOk(OrderDateResource::collection($result));
    }

}
