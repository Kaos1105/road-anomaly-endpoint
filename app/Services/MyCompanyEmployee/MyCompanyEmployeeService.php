<?php

namespace App\Services\MyCompanyEmployee;

use App\Enums\AccessHistory\AccessActionTypeEnum;
use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Enums\Common\PreviousNameFlagEnum;
use App\Enums\System\SystemCodeEnum;
use App\Models\AccessHistory;
use App\Models\ManagementDepartment;
use App\Models\ManagementDepartmentEmployee;
use App\Models\MyCompanyEmployee;
use App\Repositories\MyCompanyEmployee\IMyCompanyEmployeeRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Helpers\SystemHelper;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

class MyCompanyEmployeeService implements IMyCompanyEmployeeService
{

    public function __construct(
        public IMyCompanyEmployeeRepository $myCompanyEmployeeRepository,
    )
    {
    }

    public function getRepo(): IMyCompanyEmployeeRepository
    {
        return $this->myCompanyEmployeeRepository;
    }

    public function getChildNames(MyCompanyEmployee $myCompanyEmployee): ?string
    {
        $countRelation = $this->myCompanyEmployeeRepository->checkRelations($myCompanyEmployee);
        if ($countRelation->negotiable_count > 0) {
            return __('attributes.negotiation.table');
        }
        return null;
    }

    public function deleteRecord(MyCompanyEmployee $myCompanyEmployee): void
    {

    }

    /**
     * @throws Throwable
     */
    public function createRecord(ManagementDepartment $managementDepartment, array $dataInsert): MyCompanyEmployee|null
    {
        $result = null;
        DB::transaction(function () use ($managementDepartment, $dataInsert, &$result) {
            $myCompanyEmployee = $this->myCompanyEmployeeRepository->create($dataInsert);
            $myCompanyEmployee->managementDepartments()->attach([
                'management_department_id' => $managementDepartment->id,
            ]);

            $result = $myCompanyEmployee->load(['managementDepartments', 'employee']);
        });
        return $result;

    }

    public function findByQuery(QueryBuilder $query): Collection|array
    {
        if (empty(request('filter')['management_department_id'])) {
            return collect();
        }
        return $this->myCompanyEmployeeRepository->findByQuery($query);
    }
}
