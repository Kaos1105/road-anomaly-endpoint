<?php

namespace App\Services\Division;

use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\System\SystemCodeEnum;
use App\Helpers\FileHelper;
use App\Helpers\SystemHelper;
use App\Http\DTO\QueryParam\DivisionDropdownContractParam;
use App\Models\Division;
use App\Query\Division\DivisionContractDropdownQuery;
use App\Query\Division\DivisionDropdownQuery;
use App\Repositories\Division\IDivisionRepository;
use BenSampo\Enum\Exceptions\InvalidEnumKeyException;
use DB;
use Illuminate\Support\Collection;
use Throwable;

readonly class DivisionService implements IDivisionService
{
    public function __construct(
        private IDivisionRepository $divisionRepository,
    )
    {
    }

    public function getRepo(): IDivisionRepository
    {
        return $this->divisionRepository;
    }

    public function findByQuery(DivisionDropdownQuery $query): Collection|array
    {
        if (empty(request('filter')['department_id'])) {
            return collect();
        }
        return $this->divisionRepository->findByQuery($query);
    }

    public function getChildNames(Division $division): ?string
    {
        $countRelation = $this->divisionRepository->checkRelations($division);

        if ($countRelation->employees_count > 0) {
            return __('attributes.employee.table');
        }

        if ($countRelation->contract_workplaces_count > 0) {
            return SystemHelper::getSystemName(SystemCodeEnum::CONTRACT);
        }

        return null;
    }

    /**
     * @throws InvalidEnumKeyException
     * @throws Throwable
     */
    public function deleteRecord(Division $division): void
    {
        DB::transaction(function () use ($division) {
            if (count($division->attachmentFiles) > 0) {
                FileHelper::deleteAttachmentFiles($division->attachmentFiles, AccessibleTypeEnum::DIVISION);
            }
            $division->favorites()->delete();
            $division->delete();
        });
    }

    public function getDivisionContractDropdown(): Collection|array
    {
        $request = request();
        $filter = $request['filter'];
        if ($filter && !empty($filter['site_id']) && !empty($filter['basic_contract_id'])) {
            $query = new DivisionContractDropdownQuery($request);
            return $this->divisionRepository->findByQuery($query->setFilterParam(new DivisionDropdownContractParam(useClassification: UseFlagEnum::USE)));
        }
        return collect();
    }
}
