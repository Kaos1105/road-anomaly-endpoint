<?php

namespace App\Services\Facility;

use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Helpers\FileHelper;
use App\Http\DTO\QueryParam\FacilityCalendarParam;
use App\Models\Facility;
use App\Query\Facility\ReservationCalendarQuery;
use App\Repositories\Facility\IFacilityRepository;
use App\Trait\HasPermission;
use BenSampo\Enum\Exceptions\InvalidEnumKeyException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class FacilityService implements IFacilityService
{
    use  HasPermission;

    public function __construct(
        private IFacilityRepository $facilityRepository,
    )
    {
    }

    public function getRepo(): IFacilityRepository
    {
        return $this->facilityRepository;
    }

    public function createRecord(array $dataInsert): Facility
    {
        $facility = $this->facilityRepository->create($dataInsert);

        return $facility->load(['createdBy', 'updatedBy', 'facilityGroup.useGroup', 'responsibleUser']);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->facilityRepository->getPaginateList();
    }

    public function getChildNames(Facility $facility): ?string
    {
        $countRelation = $this->facilityRepository->checkRelations($facility);

        if ($countRelation->reservations_count > 0) {
            return __('attributes.facility.reservation');
        }
        return null;
    }


    /**
     * @throws InvalidEnumKeyException
     * @throws Throwable
     */
    public function deleteRecord(Facility $facility): void
    {
        DB::transaction(function () use ($facility) {
            if (count($facility->attachmentFiles) > 0) {
                FileHelper::deleteAttachmentFiles($facility->attachmentFiles, AccessibleTypeEnum::FACILITY);
            }
            $facility->delete();
        });
    }

    public function getCalendarMonth(SupportCollection $companyCalendar): SupportCollection
    {
        $filter = request('filter');
        if ($filter['facility_group_id'] && $filter['calendar_date']) {
            $companyCalendarDates = $companyCalendar->pluck('date')->toArray();
            $query = new ReservationCalendarQuery(new Request());
            return $this->facilityRepository
                ->getList($query->setCalendarFilterParam(
                    new FacilityCalendarParam($filter['facility_group_id'],
                        $filter['facility_classification'] ?? null)),
                    $companyCalendarDates
                );
        }
        return collect();
    }
}
