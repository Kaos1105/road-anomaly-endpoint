<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Models\Supplier;
use App\Repositories\Product\IProductRepository;
use Illuminate\Support\Collection;

interface IProductService
{
    public function getRepo(): IProductRepository;

    public function getChildNames(Product $product): ?string;

    public function topFiveBoughtProduct(Supplier $supplier): Collection;

    public function deleteRecord(Product $product): void;
}
