<?php

namespace App\Services\Division;

use App\Models\Division;
use App\Query\Division\DivisionContractDropdownQuery;
use App\Query\Division\DivisionDropdownQuery;
use App\Repositories\Division\IDivisionRepository;
use Illuminate\Support\Collection;

interface IDivisionService
{
    public function getRepo(): IDivisionRepository;

    public function findByQuery(DivisionDropdownQuery $query): Collection|array;

    public function getChildNames(Division $division): ?string;

    public function deleteRecord(Division $division): void;

    public function getDivisionContractDropdown(): Collection|array;
}
