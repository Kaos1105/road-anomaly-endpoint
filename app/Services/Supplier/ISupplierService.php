<?php

namespace App\Services\Supplier;

use App\Models\Supplier;
use App\Repositories\Supplier\ISupplierRepository;

interface ISupplierService
{
    public function getRepo(): ISupplierRepository;

    public function getChildNames(Supplier $supplier): ?string;
}
