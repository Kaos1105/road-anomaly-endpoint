<?php

namespace App\Services\Negotiation;

use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Enums\Company\IndependentEnum;
use App\Helpers\FileHelper;
use App\Http\DTO\QueryParam\NegotiationCalendarParam;
use App\Models\Negotiation;
use App\Query\Negotiation\CalendarQuery;
use App\Repositories\ClientSite\ClientSiteRepository;
use App\Repositories\Negotiation\INegotiationRepository;
use BenSampo\Enum\Exceptions\InvalidEnumKeyException;
use DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Throwable;

class NegotiationService implements INegotiationService
{
    public function __construct(
        public INegotiationRepository $negotiationRepository,
    )
    {
    }

    public function getRepo(): INegotiationRepository
    {
        return $this->negotiationRepository;
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        $request = request();
        $filter = $request['filter'];
        if (empty($filter['management_department_id'])) {
            $filter['management_department_id'] = IndependentEnum::INDEPENDENT;
        }

        $request->merge(['filter' => $filter]);
        return $this->negotiationRepository->getPaginateList();
    }

    /**
     * @throws Throwable
     */
    public function createRecord(array $dataInsert): Negotiation|null
    {
        $result = null;
        DB::transaction(function () use ($dataInsert, &$result) {
            $negotiation = $this->negotiationRepository->create($dataInsert);
            $participants = $this->listParticipants($negotiation, $dataInsert['client_employee_ids'], $dataInsert['my_company_employee_ids']);
            $negotiation->participants()->createMany($participants);
            $result = $negotiation;
        });
        return $result;
    }

    private function listParticipants(Negotiation $negotiation, ?array $clientEmployeeIds, ?array $myCompanyEmployeeIds): array
    {
        $participants = [];

        if (!empty($clientEmployeeIds)) {
            foreach ($clientEmployeeIds as $negotiableId) {
                $participants[] = [
                    'negotiation_id' => $negotiation->id,
                    'negotiable_id' => $negotiableId,
                    'negotiable_type' => AccessibleTypeEnum::CLIENT_EMPLOYEE,
                ];
            }
        }
        if (!empty($myCompanyEmployeeIds)) {
            foreach ($myCompanyEmployeeIds as $negotiableId) {
                $participants[] = [
                    'negotiation_id' => $negotiation->id,
                    'negotiable_id' => $negotiableId,
                    'negotiable_type' => AccessibleTypeEnum::MY_COMPANY_EMPLOYEE,
                ];
            }
        }
        return $participants;
    }

    /**
     * @throws InvalidEnumKeyException
     * @throws Throwable
     */
    public function deleteRecord(Negotiation $negotiation): void
    {
        DB::transaction(function () use ($negotiation) {
            if (count($negotiation->attachmentFiles) > 0) {
                FileHelper::deleteAttachmentFiles($negotiation->attachmentFiles, AccessibleTypeEnum::COMPANY);
            }
            $negotiation->delete();
        });
    }

    /**
     * @throws Throwable
     */
    public function updateRecord(array $dataUpdate, Negotiation $negotiation): Negotiation|null
    {
        DB::transaction(function () use ($dataUpdate, &$negotiation) {
            $negotiation->participants()->delete();
            $negotiation = $this->negotiationRepository->update($dataUpdate, $negotiation->id);
            $participants = $this->listParticipants($negotiation, $dataUpdate['client_employee_ids'], $dataUpdate['my_company_employee_ids']);
            $negotiation->participants()->createMany($participants);
        });
        return $negotiation;
    }

    public function showCalendar(): Collection|null
    {
        $filter = request('filter');
        if (!$filter ||
            empty($filter['management_department_id']) ||
            empty($filter['date'])
        ) {
            return collect();
        }
        $clientSiteIds = ClientSiteRepository::getClientSitesByManagementDepartment($filter['management_department_id']);
        if (count($clientSiteIds) == 0) {
            return collect();
        }

        $query = new CalendarQuery(new Request());
        return $this->negotiationRepository->getCalendar($query->setFilterParam(new NegotiationCalendarParam($filter['date'], $clientSiteIds->toArray())));
    }

}
