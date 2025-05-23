<?php

namespace App\Providers;

use App\Services\AccessHistory\AccessHistoryService;
use App\Services\AccessHistory\IAccessHistoryService;
use App\Services\AccessPermission\AccessPermissionService;
use App\Services\AccessPermission\IAccessPermissionService;
use App\Services\Announcement\AnnouncementService;
use App\Services\Announcement\IAnnouncementService;
use App\Services\AttachmentFile\AttachmentFileService;
use App\Services\AttachmentFile\IAttachmentFileService;
use App\Services\Auth\AuthService;
use App\Services\Auth\IAuthService;
use App\Services\AuthenticationHistory\AuthenticationHistoryService;
use App\Services\AuthenticationHistory\IAuthenticationHistoryService;
use App\Services\BasicContract\BasicContractService;
use App\Services\BasicContract\IBasicContractService;
use App\Services\ChatContent\ChatContentService;
use App\Services\ChatContent\IChatContentService;
use App\Services\ChatThread\ChatThreadService;
use App\Services\ChatThread\IChatThreadService;
use App\Services\ClientEmployee\ClientEmployeeService;
use App\Services\ClientEmployee\IClientEmployeeService;
use App\Services\ClientSite\ClientSiteService;
use App\Services\ClientSite\IClientSiteService;
use App\Services\Company\CompanyService;
use App\Services\Company\ICompanyService;
use App\Services\CompanyCalendar\CompanyCalendarService;
use App\Services\CompanyCalendar\ICompanyCalendarService;
use App\Services\Content\ContentService;
use App\Services\Content\IContentService;
use App\Services\ContractCondition\ContractConditionService;
use App\Services\ContractCondition\IContractConditionService;
use App\Services\ContractUserSetting\ContractUserSettingService;
use App\Services\ContractUserSetting\IContractUserSettingService;
use App\Services\ContractWorkplace\ContractWorkplaceService;
use App\Services\ContractWorkplace\IContractWorkplaceService;
use App\Services\Customer\CustomerService;
use App\Services\Customer\ICustomerService;
use App\Services\Dashboard\IMainDashboardService;
use App\Services\Dashboard\INegotiationDashboardService;
use App\Services\Dashboard\ISocialDashboardService;
use App\Services\Dashboard\MainDashboardService;
use App\Services\Dashboard\NegotiationDashboardService;
use App\Services\Dashboard\SocialDashboardService;
use App\Services\Department\DepartmentService;
use App\Services\Department\IDepartmentService;
use App\Services\DeviceInformation\DeviceInformationService;
use App\Services\DeviceInformation\IDeviceInformationService;
use App\Services\Display\DisplayService;
use App\Services\Display\IDisplayService;
use App\Services\Division\DivisionService;
use App\Services\Division\IDivisionService;
use App\Services\Employee\EmployeeService;
use App\Services\Employee\IEmployeeService;
use App\Services\EventClassification\EventClassificationService;
use App\Services\EventClassification\IEventClassificationService;
use App\Services\Excel\ExportExcelService;
use App\Services\Excel\IExportExcelService;
use App\Services\Facility\FacilityService;
use App\Services\Facility\IFacilityService;
use App\Services\FacilityGroup\FacilityGroupService;
use App\Services\FacilityGroup\IFacilityGroupService;
use App\Services\Excel\ImportExcelService;
use App\Services\Excel\IImportExcelService;
use App\Services\FacilityUserSetting\FacilityUserSettingService;
use App\Services\FacilityUserSetting\IFacilityUserSettingService;
use App\Services\FAQ\AnswerFileService;
use App\Services\FAQ\AnswerService;
use App\Services\FAQ\AnswerTextService;
use App\Services\FAQ\IAnswerFileService;
use App\Services\FAQ\IAnswerService;
use App\Services\FAQ\IAnswerTextService;
use App\Services\FAQ\IQuestionService;
use App\Services\FAQ\QuestionService;
use App\Services\Favorite\FavoriteService;
use App\Services\Favorite\IFavoriteService;
use App\Services\Group\GroupService;
use App\Services\Group\IGroupService;
use App\Services\IndividualContract\IIndividualContractService;
use App\Services\IndividualContract\IndividualContractService;
use App\Services\Layout\ILayoutService;
use App\Services\Layout\LayoutService;
use App\Services\ManagementDepartment\IManagementDepartmentService;
use App\Services\ManagementDepartment\ManagementDepartmentService;
use App\Services\ManagementGroup\IManagementGroupService;
use App\Services\ManagementGroup\ManagementGroupService;
use App\Services\MyCompanyEmployee\IMyCompanyEmployeeService;
use App\Services\MyCompanyEmployee\MyCompanyEmployeeService;
use App\Services\Negotiation\INegotiationEmployeeService;
use App\Services\Negotiation\INegotiationService;
use App\Services\Negotiation\NegotiationEmployeeService;
use App\Services\Negotiation\NegotiationService;
use App\Services\Product\IProductService;
use App\Services\Product\ProductService;
use App\Services\Reservation\IReservationService;
use App\Services\Reservation\ReservationService;
use App\Services\ScheduleDaily\DailyScheduleService;
use App\Services\ScheduleDaily\IDailyScheduleService;
use App\Services\ScheduleTime\ITimeScheduleService;
use App\Services\ScheduleTime\TimeScheduleService;
use App\Services\ScheduleWeekly\IWeeklyScheduleService;
use App\Services\ScheduleWeekly\WeeklyScheduleService;
use App\Services\Site\ISiteService;
use App\Services\Site\SiteService;
use App\Services\SocialData\ISocialDataService;
use App\Services\SocialData\SocialDataService;
use App\Services\SocialEvent\ISocialEventService;
use App\Services\SocialEvent\SocialEventService;
use App\Services\Supplier\ISupplierService;
use App\Services\Supplier\SupplierService;
use App\Services\System\ISystemService;
use App\Services\System\SystemService;
use App\Services\Transfer\ITransferService;
use App\Services\Transfer\TransferService;
use Illuminate\Support\ServiceProvider;

class InversionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(IAuthService::class, AuthService::class);
        $this->app->bind(ISystemService::class, SystemService::class);
        $this->app->bind(IEmployeeService::class, EmployeeService::class);
        $this->app->bind(IDepartmentService::class, DepartmentService::class);
        $this->app->bind(IAccessPermissionService::class, AccessPermissionService::class);
        $this->app->bind(IAccessHistoryService::class, AccessHistoryService::class);
        $this->app->bind(IAttachmentFileService::class, AttachmentFileService::class);
        $this->app->bind(IFavoriteService::class, FavoriteService::class);
        $this->app->bind(ICompanyService::class, CompanyService::class);
        $this->app->bind(ISiteService::class, SiteService::class);
        $this->app->bind(IDivisionService::class, DivisionService::class);
        $this->app->bind(ITransferService::class, TransferService::class);
        $this->app->bind(IEventClassificationService::class, EventClassificationService::class);
        $this->app->bind(IManagementGroupService::class, ManagementGroupService::class);
        $this->app->bind(IDisplayService::class, DisplayService::class);
        $this->app->bind(ISupplierService::class, SupplierService::class);
        $this->app->bind(ICustomerService::class, CustomerService::class);
        $this->app->bind(IProductService::class, ProductService::class);
        $this->app->bind(ISocialDashboardService::class, SocialDashboardService::class);
        $this->app->bind(ISocialEventService::class, SocialEventService::class);
        $this->app->bind(ISocialDataService::class, SocialDataService::class);
        $this->app->bind(IContentService::class, ContentService::class);
        $this->app->bind(IQuestionService::class, QuestionService::class);
        $this->app->bind(IAnswerTextService::class, AnswerTextService::class);
        $this->app->bind(IAnswerFileService::class, AnswerFileService::class);
        $this->app->bind(IAnswerService::class, AnswerService::class);
        $this->app->bind(IManagementDepartmentService::class, ManagementDepartmentService::class);
        $this->app->bind(IMyCompanyEmployeeService::class, MyCompanyEmployeeService::class);
        $this->app->bind(IClientSiteService::class, ClientSiteService::class);
        $this->app->bind(IClientEmployeeService::class, ClientEmployeeService::class);
        $this->app->bind(INegotiationService::class, NegotiationService::class);
        $this->app->bind(INegotiationEmployeeService::class, NegotiationEmployeeService::class);
        $this->app->bind(IChatThreadService::class, ChatThreadService::class);
        $this->app->bind(IChatContentService::class, ChatContentService::class);
        $this->app->bind(ICompanyCalendarService::class, CompanyCalendarService::class);
        $this->app->bind(IWeeklyScheduleService::class, WeeklyScheduleService::class);
        $this->app->bind(IDailyScheduleService::class, DailyScheduleService::class);
        $this->app->bind(ITimeScheduleService::class, TimeScheduleService::class);
        $this->app->bind(IGroupService::class, GroupService::class);
        $this->app->bind(IFacilityGroupService::class, FacilityGroupService::class);
        $this->app->bind(IFacilityService::class, FacilityService::class);
        $this->app->bind(IReservationService::class, ReservationService::class);
        $this->app->bind(IFacilityUserSettingService::class, FacilityUserSettingService::class);
        $this->app->bind(IImportExcelService::class, ImportExcelService::class);
        $this->app->bind(IExportExcelService::class, ExportExcelService::class);
        $this->app->bind(INegotiationDashboardService::class, NegotiationDashboardService::class);
        $this->app->bind(IAnnouncementService::class, AnnouncementService::class);
        $this->app->bind(IMainDashboardService::class, MainDashboardService::class);
        $this->app->bind(ILayoutService::class, LayoutService::class);
        $this->app->bind(IAuthenticationHistoryService::class, AuthenticationHistoryService::class);
        $this->app->bind(IDeviceInformationService::class, DeviceInformationService::class);
        $this->app->bind(IBasicContractService::class, BasicContractService::class);
        $this->app->bind(IIndividualContractService::class, IndividualContractService::class);
        $this->app->bind(IContractConditionService::class, ContractConditionService::class);
        $this->app->bind(IContractWorkplaceService::class, ContractWorkplaceService::class);
        $this->app->bind(IContractUserSettingService::class, ContractUserSettingService::class);
        //:end-bindings:
        //:end-bindings:
    }
}
