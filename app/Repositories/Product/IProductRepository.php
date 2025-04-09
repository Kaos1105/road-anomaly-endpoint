<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Models\Supplier;
use App\Query\Product\SocialDataProductQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;

interface IProductRepository extends RepositoryInterface
{
    public function getDetail(Product $detail): Product;

    public function getPaginateList(): LengthAwarePaginator;

    public function createProduct(array $dataInsert): Product;

    public function updateProduct(array $dataUpdate, Product $customer): Product;

    public function allSuppliersByProducts(): Collection;

    public function allProductsBySupplier(Supplier $supplier): Collection;

    public function getSocialDataProductDropdown(SocialDataProductQuery $query): Collection;

    public function numberOfRecords(): int;

    public function getFiveYearTotalOfProduct(Product $detail): Product;

    public function mostBoughtProductPastThreeYears(Supplier $supplier, Collection $socialData): Collection;

    public function checkRelations(Product $product): Model|Product;

}
