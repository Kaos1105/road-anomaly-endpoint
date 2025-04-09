<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\Product\UpsertProductRequest;
use App\Http\Resources\Company\CompanyShortNameResource;
use App\Http\Resources\Product\FiveYearProductResource;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductDetailResource;
use App\Http\Resources\Product\ProductDropdownResource;
use App\Http\Resources\Product\ProductItemResource;
use App\Models\Product;
use App\Models\Supplier;
use App\Query\Product\SocialDataProductQuery;
use App\Services\Product\IProductService;

class ProductController extends Controller
{
    public function __construct(
        private readonly IProductService $productService,
    )
    {
    }

    public function index(): ResponseData
    {
        $suppliers = $this->productService->getRepo()->getPaginateList();

        return $this->httpOk(new ProductCollection($suppliers));
    }

    public function show(Product $product): ResponseData
    {
        $result = $this->productService->getRepo()->getDetail($product);

        return $this->httpOk(new ProductDetailResource($result));
    }

    public function store(UpsertProductRequest $request): ResponseData
    {
        $data = $request->validated();
        $result = $this->productService->getRepo()->createProduct($data);

        return $this->httpCreated(new ProductDetailResource($result));
    }

    public function update(UpsertProductRequest $request, Product $product): ResponseData
    {
        $data = $request->validated();
        $result = $this->productService->getRepo()->updateProduct($data, $product);

        return $this->httpOk(new ProductDetailResource($result));
    }

    public function destroy(Product $product): ResponseData
    {

        $childNames = $this->productService->getChildNames($product);
        if ($childNames) {
            return $this->httpBadRequest(msg: __('errors.can_not_delete', ['attr1' => $childNames]));
        }

        $this->productService->deleteRecord($product);

        return $this->httpNoContent();
    }

    public function getDropdownSupplierCompany(): ResponseData
    {
        $suppliers = $this->productService->getRepo()->allSuppliersByProducts();

        return $this->httpOk(CompanyShortNameResource::collection($suppliers));
    }

    public function getProductSupplier(Supplier $supplier): ResponseData
    {
        $suppliers = $this->productService->getRepo()->allProductsBySupplier($supplier);

        return $this->httpOk(ProductItemResource::collection($suppliers));
    }

    public function getSocialDataProducts(SocialDataProductQuery $query): ResponseData
    {
        $suppliers = $this->productService->getRepo()->getSocialDataProductDropdown($query);

        return $this->httpOk(ProductDropdownResource::collection($suppliers));
    }

    public function getTopFiveBoughtProducts(Supplier $supplier): ResponseData
    {
        $products = $this->productService->topFiveBoughtProduct($supplier);

        return $this->httpOk($products->toArray());
    }

    public function getFiveYearSocialData(Product $product): ResponseData
    {
        $result = $this->productService->getRepo()->getFiveYearTotalOfProduct($product);

        return $this->httpOk(FiveYearProductResource::make($result));
    }
}
