<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\Supplier\UpsertSupplierRequest;
use App\Http\Resources\Supplier\FiveYearTotalAmountSupplierResource;
use App\Http\Resources\Supplier\SupplierCollection;
use App\Http\Resources\Supplier\SupplierDetailResource;
use App\Http\Resources\Supplier\SupplierRelatedResource;
use App\Models\SocialEvent;
use App\Models\Supplier;
use App\Services\Supplier\ISupplierService;

class SupplierController extends Controller
{
    public function __construct(
        private readonly ISupplierService $supplierService,
    )
    {
    }

    public function index(): ResponseData
    {
        $suppliers = $this->supplierService->getRepo()->getPaginateList();

        return $this->httpOk(new SupplierCollection($suppliers));
    }

    public function show(Supplier $supplier): ResponseData
    {
        $result = $this->supplierService->getRepo()->getDetail($supplier);

        return $this->httpOk(new SupplierDetailResource($result));
    }

    public function store(UpsertSupplierRequest $request): ResponseData
    {
        $data = $request->validated();
        $supplier = $this->supplierService->getRepo()->create($data);
        $result = $this->supplierService->getRepo()->getDetail($supplier);

        return $this->httpCreated(new SupplierDetailResource($result));
    }

    public function update(UpsertSupplierRequest $request, Supplier $supplier): ResponseData
    {
        $data = $request->validated();
        $this->supplierService->getRepo()->update($data, $supplier->id);
        $result = $this->supplierService->getRepo()->getDetail($supplier);

        return $this->httpOk(new SupplierDetailResource($result));
    }

    public function destroy(Supplier $supplier): ResponseData
    {
        $childNames = $this->supplierService->getChildNames($supplier);
        if ($childNames) {
            return $this->httpBadRequest(msg: __('errors.can_not_delete', ['attr1' => $childNames]));
        }

        $this->supplierService->getRepo()->delete($supplier->id);

        return $this->httpNoContent();
    }

    public function getSocialEventSuppliers(SocialEvent $socialEvent): ResponseData
    {
        $result = $this->supplierService->getRepo()->getSocialEventSuppliers($socialEvent);

        return $this->httpOk(SupplierRelatedResource::collection($result));
    }

    public function getFiveYearTotalAmount(Supplier $supplier): ResponseData
    {
        $result = $this->supplierService->getRepo()->getFiveYearTotalOfSupplier($supplier);

        return $this->httpOk(FiveYearTotalAmountSupplierResource::make($result));
    }
}
