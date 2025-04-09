<?php

namespace App\Services\FacilityUserSetting;

use App\Enums\Facility\HolidayDisplayEnum;
use App\Models\FacilityUserSetting;
use App\Repositories\FacilityUserSetting\IFacilityUserSettingRepository;
use App\Trait\HasPermission;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class FacilityUserSettingService implements IFacilityUserSettingService
{
    use  HasPermission;

    public function __construct(
        private IFacilityUserSettingRepository $facilityUserSettingRepository,
    )
    {
    }

    public function getRepo(): IFacilityUserSettingRepository
    {
        return $this->facilityUserSettingRepository;
    }

    public function createRecord(array $dataInsert): FacilityUserSetting
    {
        $userId = \Auth::user()->employee_id;
        $userSetting = $this->facilityUserSettingRepository->getDetail($userId);
        if ($userSetting) {
            $dataInsert = [
                ...$dataInsert,
                'updated_at' => Carbon::now(),
                'updated_by' => $userId,
            ];
            $facilityUserSetting = $this->facilityUserSettingRepository->update($dataInsert, $userSetting->id);
        } else {
            $dataInsert = [
                ...$dataInsert,
                'user_id' => $userId,
                'created_at' => Carbon::now(),
                'created_by' => $userId,
                'updated_at' => Carbon::now(),
                'updated_by' => $userId,
            ];
            $facilityUserSetting = $this->facilityUserSettingRepository->create($dataInsert);
        }
        return $facilityUserSetting->load(['createdBy', 'updatedBy', 'facilityGroup', 'user']);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->facilityUserSettingRepository->getPaginateList();
    }

    public function showUserSetting(): FacilityUserSetting
    {
        $userSetting = $this->facilityUserSettingRepository->getDetail(\Auth::user()->employee_id);
        if (!$userSetting) {
            $userSetting = FacilityUserSetting::make([
                'holiday_display' => HolidayDisplayEnum::DISPLAY
            ]);
        }
        return $userSetting;
    }
}
