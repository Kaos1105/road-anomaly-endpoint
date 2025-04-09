<?php

namespace App\Services\Dashboard;

use App\Enums\AccessHistory\AccessActionTypeEnum;
use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Enums\AccessPermission\Permission1FlagEnum;
use App\Enums\Common\DateTimeEnum;
use App\Enums\Common\PaginationEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Schedule\CalendarClassificationEnum;
use App\Enums\Schedule\DisplayWeeklyClassificationEnum;
use App\Enums\Schedule\WeeklyEnum;
use App\Enums\Schedule\WorkClassificationEnum;
use App\Enums\Schedule\YearEnum;
use App\Enums\System\OperationFlagEnum;
use App\Enums\System\SystemCodeEnum;
use App\Http\DTO\Announcement\AnnouncementCardDashboardData;
use App\Http\DTO\Facility\FacilityPortalData;
use App\Http\DTO\Portal\FacilityCardData;
use App\Http\DTO\Portal\ScheduleManagementCardData;
use App\Http\DTO\Portal\SubSystemCardData;
use App\Http\DTO\QueryParam\ScheduleCalendarRangeDateParam;
use App\Http\DTO\Schedule\MonthCalendarData;
use App\Http\DTO\Schedule\ScheduleBoxMainDashboardData;
use App\Http\Resources\AccessHistory\AccessItemResource;
use App\Http\Resources\Announcement\AnnouncementCardDashboardResource;
use App\Http\Resources\CompanyCalendar\CompanyCalendarItemResource;
use App\Http\Resources\Facility\FacilityReservationPortalCollection;
use App\Http\Resources\FacilityUserSetting\FacilityUserSettingResource;
use App\Http\Resources\WeeklySchedule\WeeklyScheduleItemResource;
use App\Models\Company;
use App\Models\CompanyCalendar;
use App\Models\System;
use App\Http\DTO\Portal\WeeklyScheduleCardData;
use App\Models\WeeklySchedule;
use App\Query\Schedule\CompanyCalendarQuery;
use App\Query\Schedule\DailyScheduleQuery;
use App\Query\Schedule\TimeScheduleQuery;
use App\Repositories\AccessHistory\IAccessHistoryRepository;
use App\Repositories\Announcement\IAnnouncementRepository;
use App\Repositories\Company\ICompanyRepository;
use App\Repositories\CompanyCalendar\ICompanyCalendarRepository;
use App\Repositories\Facility\IFacilityRepository;
use App\Repositories\FacilityGroup\IFacilityGroupRepository;
use App\Repositories\FacilityUserSetting\IFacilityUserSettingRepository;
use App\Repositories\ScheduleDaily\IDailyScheduleRepository;
use App\Repositories\ScheduleTime\ITimeScheduleRepository;
use App\Repositories\ScheduleWeekly\IWeeklyScheduleRepository;
use App\Trait\HasPermission;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Collection as SupportCollection;

readonly class MainDashboardService implements IMainDashboardService
{
    use HasPermission;

    public function __construct(
        private IAccessHistoryRepository       $accessHistoryRepository,
        private IAnnouncementRepository        $announcementRepository,
        private IFacilityGroupRepository       $facilityGroupRepository,
        private IFacilityRepository            $facilityRepository,
        private ICompanyRepository             $companyRepository,
        private ICompanyCalendarRepository     $companyCalendarRepository,
        private IWeeklyScheduleRepository      $weeklyScheduleRepository,
        private IFacilityUserSettingRepository $facilityUserSettingRepository,
        public ITimeScheduleRepository         $timeScheduleRepository,
        public IDailyScheduleRepository        $dailyScheduleRepository,
    )
    {

    }

    public function getContentCardBySubSystem(): SubSystemCardData
    {
        $filter = request('filter');
        if (!$filter || empty($filter['system_id'])) {
            return new SubSystemCardData();
        }

        $accessPermission = $this->getPermissionBySystemId($filter['system_id']);
        if (!$accessPermission || $accessPermission->permission_1 == Permission1FlagEnum::UN_AUTHORIZED_USER) {
            return new SubSystemCardData();
        }
        $accessPermission->load('system');
        $system = $accessPermission->system;
        $announcement = $this->announcementRepository->getAnnouncementBySubSystemId($system->id);

        $operationClass = $this->checkOperationSystem($system);
        if ($operationClass == OperationFlagEnum::STOP) {
            return new SubSystemCardData(true, false, __('message.unavailable_system'), null, $announcement);
        }

        $accessibleTypes = match ($system->code) {
            SystemCodeEnum::ORGANIZATION => [
                AccessibleTypeEnum::COMPANY,
                AccessibleTypeEnum::SITE,
                AccessibleTypeEnum::DEPARTMENT,
                AccessibleTypeEnum::DIVISION,
                AccessibleTypeEnum::EMPLOYEE,
                AccessibleTypeEnum::TRANSFER,
            ],
            SystemCodeEnum::SOCIAL => [
                AccessibleTypeEnum::EVENT_CLASSIFICATION,
                AccessibleTypeEnum::MANAGEMENT_GROUP,
                AccessibleTypeEnum::CUSTOMER,
                AccessibleTypeEnum::SUPPLIER,
                AccessibleTypeEnum::PRODUCT,
                AccessibleTypeEnum::SOCIAL_EVENT,
                AccessibleTypeEnum::SOCIAL_DATA,
            ],
            SystemCodeEnum::NEGOTIATION => [
                AccessibleTypeEnum::MANAGEMENT_DEPARTMENT,
                AccessibleTypeEnum::MANAGEMENT_DEPARTMENT_EMPLOYEE,
                AccessibleTypeEnum::CLIENT_SITE,
                AccessibleTypeEnum::CLIENT_EMPLOYEE,
                AccessibleTypeEnum::NEGOTIATION,
            ],
            SystemCodeEnum::SNET => [
                AccessibleTypeEnum::LOGIN,
                AccessibleTypeEnum::SYSTEM,
                AccessibleTypeEnum::DISPLAY,
                AccessibleTypeEnum::CONTENT,
                AccessibleTypeEnum::QUESTION,
                AccessibleTypeEnum::ACCESS_PERMISSION,

            ],
            default => [],
        };

        $accessHistories = $this->accessHistoryRepository->findAccessHistoryBySystem($system, $accessibleTypes, PaginationEnum::NUMBER_RECORD_DASHBOARD_5);

        return new SubSystemCardData(true, true, null, $accessHistories, $announcement);
    }

    private function checkOperationSystem(System $system): int
    {
        if ($system->use_classification !== UseFlagEnum::USE) {
            return OperationFlagEnum::STOP;
        }

        $now = Carbon::now();
        $isInOperation = (
            ($system->start_date <= $now && $system->end_date >= $now) ||
            (empty($system->start_date) && $system->end_date >= $now) ||
            ($system->start_date <= $now && empty($system->end_date)) ||
            (empty($system->start_date) && empty($system->end_date))
        );

        return $isInOperation ? OperationFlagEnum::IN_OPERATION : OperationFlagEnum::STOP;
    }

    public function getAnnouncementCardBySubSystem(): AnnouncementCardDashboardData
    {
        $filter = request('filter');
        if (!$filter || empty($filter['system_id'])) {
            return new AnnouncementCardDashboardData();
        }
        $accessPermission = $this->getPermissionBySystemId($filter['system_id']);
        if (!$accessPermission || $accessPermission->permission_1 != Permission1FlagEnum::SYSTEM_MANAGER) {
            return new AnnouncementCardDashboardData();
        }

        $numberRecord = request('records') ?? PaginationEnum::NUMBER_RECORD_DASHBOARD;

        $history = $this->accessHistoryRepository->findAnnouncementHistoryBySystemId($filter['system_id'], $numberRecord);

        $announcements = $this->announcementRepository->getAnnouncementBySubSystemId($filter['system_id']);
        return new AnnouncementCardDashboardData(
            true,
            AccessItemResource::collection($history)->collection,
            AnnouncementCardDashboardResource::collection($announcements)->collection
        );
    }

    public function getWeeklySchedule(): WeeklyScheduleCardData|null
    {
        $accessPermission = $this->getEmployeePermission(SystemCodeEnum::SCHEDULE);
        if (!$accessPermission || $accessPermission->permission_1 == Permission1FlagEnum::UN_AUTHORIZED_USER) {
            return new WeeklyScheduleCardData(false, false);
        }

        $accessPermission->load('system');
        $system = $accessPermission->system;
        $operationClass = $this->checkOperationSystem($system);
        if ($operationClass == OperationFlagEnum::STOP) {
            return new WeeklyScheduleCardData(true, false, __('message.unavailable_system'));
        }
        $result = $this->weeklyScheduleRepository->getUserWeeklySchedules(['displayEmployee']);

        $calendar = $this->showWeeklyCalendar($result);
        return new WeeklyScheduleCardData(true, true, null, $calendar);
    }

    public function getScheduleManagementCard(): ScheduleManagementCardData|null
    {
        $accessPermission = $this->getEmployeePermission(SystemCodeEnum::SCHEDULE);
        if (!$accessPermission || $accessPermission->permission_1 != Permission1FlagEnum::SYSTEM_MANAGER) {
            return new ScheduleManagementCardData();
        }

        $accessPermission->load('system');
        $system = $accessPermission->system;
        $announcements = $this->announcementRepository->getAnnouncementBySubSystemId($system->id);

        $operationClass = $this->checkOperationSystem($system);
        if ($operationClass == OperationFlagEnum::STOP) {
            return new ScheduleManagementCardData(true, false, __('message.unavailable_system'), null, $announcements);
        }

        $listYears = $this->getListYears();
        $company = $this->companyRepository->checkExistShinichiro();
        $message = $this->getNotificationFromCompanyCalendar($company);

        return new ScheduleManagementCardData(true, true, null, new ScheduleBoxMainDashboardData($listYears, $message), $announcements);
    }

    public function getFacilityCard(): FacilityCardData|null
    {
        $accessPermission = $this->getEmployeePermission(SystemCodeEnum::FACILITY);
        if (!$accessPermission || $accessPermission->permission_1 == Permission1FlagEnum::UN_AUTHORIZED_USER) {
            return new FacilityCardData();
        }

        $accessPermission->load('system');
        $system = $accessPermission->system;
        $announcements = $this->announcementRepository->getAnnouncementBySubSystemId($system->id);

        $operationClass = $this->checkOperationSystem($system);
        if ($operationClass == OperationFlagEnum::STOP) {
            return new FacilityCardData(true, false, __('message.unavailable_system'), null, $announcements);
        }

        $facilityGroupCount = $this->facilityGroupRepository->countPortalData();
        if ($facilityGroupCount === 0) {
            return new FacilityCardData(
                true, true, null,
                new FacilityPortalData(__('message.facility.no_facility_group'), false),
                $announcements
            );
        }

        $userSetting = $this->facilityUserSettingRepository->getDetail(\Auth::user()->employee_id);

        if (!$userSetting) {
            return new FacilityCardData(
                true, true, null,
                new FacilityPortalData(__('message.facility.no_user_setting'), true),
                $announcements
            );
        }

        $facilities = $this->facilityRepository->getFacilityReservationPortal($userSetting->facility_group_id);
        if ($facilities->isEmpty()) {
            return new FacilityCardData(
                true, true, null,
                new FacilityPortalData(__('message.facility.no_user_setting'), true),
                $announcements
            );
        }
        $companyCalendar = $this->getDashboardCompanyCalendar();
        return new FacilityCardData(true, true, null,
            new FacilityPortalData(
                null,
                true,
                true,
                new FacilityReservationPortalCollection($facilities),
                facilityUserSetting: FacilityUserSettingResource::make($userSetting),
                companyCalendar: CompanyCalendarItemResource::make($companyCalendar)
            ),
            $announcements
        );
    }

    private function showWeeklyCalendar(Collection $weeklySchedule): Collection
    {
        return $weeklySchedule->map(function (WeeklySchedule $weeklySchedule) {
            list($start, $end) = match ($weeklySchedule->display_weekly_classification) {
                DisplayWeeklyClassificationEnum::LAST_WEEK => $this->getWeekRange(WeeklyEnum::LAST_WEEK),
                DisplayWeeklyClassificationEnum::NEXT_WEEK => $this->getWeekRange(WeeklyEnum::NEXT_WEEK),
                DisplayWeeklyClassificationEnum::TWO_WEEK_FROM_THIS_WEEK => $this->getWeekRange(WeeklyEnum::TWO_WEEK_FROM_NOW),
                DisplayWeeklyClassificationEnum::THREE_WEEK_FROM_THIS_WEEK => $this->getWeekRange(WeeklyEnum::THREE_WEEK_FROM_NOW),
                default => $this->getWeekRange(WeeklyEnum::THIS_WEEK),
            };
            $companyCalendar = $this->getWeeklyCompanyCalendar($start, $end);
            $dailySchedule = $this->getWeeklyDailySchedule($start, $end, $weeklySchedule->display_employee_id);
            $timeSchedule = $this->getWeeklyTimeSchedule($start, $end, $weeklySchedule->display_employee_id);
            return WeeklyScheduleItemResource::make($weeklySchedule)->setParams(MonthCalendarData::mapRangeDateCollection($start, $end, $dailySchedule, $companyCalendar, $timeSchedule));
        });
    }

    private function getWeeklyCompanyCalendar(Carbon $start, Carbon $end): \Illuminate\Database\Eloquent\Collection|null
    {
        $query = new CompanyCalendarQuery(new Request());
        return $this->companyCalendarRepository->getList($query->setCalendarRangeDateFilterParam(new ScheduleCalendarRangeDateParam($start, $end)));
    }

    private function getWeeklyDailySchedule(Carbon $start, Carbon $end, int $displayEmployeeId): \Illuminate\Database\Eloquent\Collection|null
    {
        $query = new DailyScheduleQuery(new Request());
        return $this->dailyScheduleRepository->getList($query->setCalendarRangeDateFilterParam(new ScheduleCalendarRangeDateParam($start, $end, $displayEmployeeId)));
    }

    private function getWeeklyTimeSchedule(Carbon $start, Carbon $end, int $displayEmployeeId): \Illuminate\Database\Eloquent\Collection
    {
        $query = new TimeScheduleQuery(new Request());
        return $this->timeScheduleRepository->getList($query->setCalendarRangeDateFilterParam(new ScheduleCalendarRangeDateParam($start, $end, $displayEmployeeId)));
    }

    private function getWeekRange(int $weeksAhead): array
    {
        $date = Carbon::now()->setTimezone(env('APP_TIMEZONE') ?? DateTimeEnum::TOKYO_TIMEZONE);
        return [
            $date->clone()->addWeeks($weeksAhead)->startOfWeek(CarbonInterface::SUNDAY),
            $date->clone()->addWeeks($weeksAhead)->endOfWeek()
        ];
    }

    private function getDashboardCompanyCalendar(): CompanyCalendar
    {
        $now = Carbon::now();
        $date = $now->format(DateTimeEnum::DATE_FORMAT_V2);
        $companyCalendar = CompanyCalendar::where('date', $date)->first();
        if (!($companyCalendar)) {
            return CompanyCalendar::make([
                "date" => $date,
                "calendar_classification" => CalendarClassificationEnum::WEEKDAY,
                "calendar_contents" => null,
                "work_classification" => $now->dayOfWeek === 0 ? WorkClassificationEnum::DAY_OFF : WorkClassificationEnum::WORK_DAY,
            ]);
        }
        return $companyCalendar;
    }

    /**
     * Check if the company calendar has been created for the next financial year.
     */
    private function getNotificationFromCompanyCalendar(?Company $company): string|null
    {
        if ($company) {
            $currenDate = Carbon::now();
            $year = $currenDate->year;

            $checkDate = Carbon::parse($year . '-' . YearEnum::START_OF_FISCAL_YEAR . '-01');
            // if pass March
            if ($currenDate->month >= YearEnum::START_OF_FISCAL_YEAR - 1) {
                $startDate = $checkDate->clone();
            } else {
                $startDate = $checkDate->clone()->subYear();
            }

            $endDate = $startDate->copy()->addYear()->subDay();

            $total = $this->companyCalendarRepository->countCompanyCalendarDuringPeriod($company->id, $startDate, $endDate);
            if ($total > 0) {
                return null;
            }
        }
        return __('message.schedule.warming_company_calendar');
    }

    private function getListYears(): SupportCollection
    {
        $startYear = YearEnum::YEAR_OF_DEVELOPMENT;
        $endYear = Carbon::now()->addYear()->year;
        return collect(range($startYear, $endYear));
    }
}
