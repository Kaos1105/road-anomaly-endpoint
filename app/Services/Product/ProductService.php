<?php

namespace App\Services\Product;

use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Helpers\FileHelper;
use App\Http\Resources\Product\TopFiveProductResource;
use App\Models\Product;
use App\Models\SocialData;
use App\Models\Supplier;
use App\Repositories\Product\IProductRepository;
use App\Repositories\SocialData\ISocialDataRepository;
use BenSampo\Enum\Exceptions\InvalidEnumKeyException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductService implements IProductService
{
    public function __construct(
        public IProductRepository    $productRepository,
        public ISocialDataRepository $socialDataRepository
    )
    {
    }

    public function getRepo(): IProductRepository
    {
        return $this->productRepository;
    }

    public function getChildNames(Product $product): ?string
    {
        $countRelation = $this->productRepository->checkRelations($product);
        if ($countRelation->social_data_count > 0) {
            return __('attributes.social_data.table');
        }
        return null;
    }

    public function topFiveBoughtProduct(Supplier $supplier): Collection
    {
        $socialDataPastThreeYear = $this->socialDataRepository->getPaidSocialDataPastThreeYears();
        $product = $this->productRepository->mostBoughtProductPastThreeYears($supplier, $socialDataPastThreeYear);

        return $product->map(function (Product $product) use ($socialDataPastThreeYear) {
            $socialData = $socialDataPastThreeYear->filter(function (SocialData $socialData) use ($product) {
                return $socialData->product_id == $product->id;
            });
            return TopFiveProductResource::make($product)->setParams($socialData);
        });
    }

    /**
     * @throws InvalidEnumKeyException
     * @throws Throwable
     */
    public function deleteRecord(Product $product): void
    {
        DB::transaction(function () use ($product) {
            if (count($product->attachmentFiles) > 0) {
                FileHelper::deleteAttachmentFiles($product->attachmentFiles, AccessibleTypeEnum::PRODUCT);
            }
            $product->delete();
        });
    }

}
