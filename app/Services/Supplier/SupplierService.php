<?php

namespace App\Services\Supplier;

use App\Models\Supplier;
use App\Repositories\Supplier\ISupplierRepository;

class SupplierService implements ISupplierService
{
    public function __construct(
        private ISupplierRepository $supplierRepository,
    )
    {
    }

    public function getRepo(): ISupplierRepository
    {
        return $this->supplierRepository;
    }

    public function getChildNames(Supplier $supplier): ?string
    {
        $countRelation = $this->supplierRepository->checkRelations($supplier);
        if ($countRelation->products_count > 0) {
            return __('attributes.product.table');
        }
        return null;
    }
}
