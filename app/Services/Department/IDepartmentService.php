<?php

namespace App\Services\Department;

use App\Models\Department;
use App\Repositories\Department\IDepartmentRepository;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

interface IDepartmentService
{
    public function getRepo(): IDepartmentRepository;

    public function findByQuery(QueryBuilder $query, bool $isOrganization = false): Collection|array;

    public function getChildNames(Department $department): ?string;

    public function deleteRecord(Department $department): void;

    public function getShinichiroDepartments(): Collection|array;
}
