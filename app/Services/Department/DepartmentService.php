<?php

namespace App\Services\Department;

use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Enums\System\SystemCodeEnum;
use App\Helpers\FileHelper;
use App\Helpers\SystemHelper;
use App\Models\Department;
use App\Repositories\Department\IDepartmentRepository;
use BenSampo\Enum\Exceptions\InvalidEnumKeyException;
use DB;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

readonly class DepartmentService implements IDepartmentService
{
    public function __construct(
        private IDepartmentRepository $departmentRepository,
    )
    {
    }

    public function getRepo(): IDepartmentRepository
    {
        return $this->departmentRepository;
    }

    public function findByQuery(QueryBuilder $query, bool $isOrganization = false): Collection|array
    {
        if ($isOrganization && empty(request('filter')['site_id'])) {
            return collect();
        }
        return $this->departmentRepository->findByQuery($query);
    }

    public function getChildNames(Department $department): ?string
    {
        $countRelation = $this->departmentRepository->checkRelations($department);
        if ($countRelation->employees_count > 0) {
            return __('attributes.employee.table');
        }

        if ($countRelation->divisions_count > 0) {
            return __('attributes.division.table');
        }

        if ($countRelation->suppliers_count > 0 || $countRelation->customers_count > 0) {
            return SystemHelper::getSystemName(SystemCodeEnum::SOCIAL);
        }

        if ($countRelation->management_departments_count > 0) {
            return SystemHelper::getSystemName(SystemCodeEnum::NEGOTIATION);
        }
        return null;
    }

    /**
     * @throws InvalidEnumKeyException
     * @throws Throwable
     */
    public function deleteRecord(Department $department): void
    {
        DB::transaction(function () use ($department) {
            if (count($department->attachmentFiles) > 0) {
                FileHelper::deleteAttachmentFiles($department->attachmentFiles, AccessibleTypeEnum::DEPARTMENT);
            }
            $department->favorites()->delete();
            $department->delete();
        });
    }

    public function getShinichiroDepartments(): Collection|array
    {
        return $this->departmentRepository->getShinichiroDepartments();
    }

}
