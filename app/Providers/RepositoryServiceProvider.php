<?php

namespace App\Providers;

use App\Repositories\AccessHistory\AccessHistoryRepository;
use App\Repositories\AccessHistory\IAccessHistoryRepository;
use App\Repositories\AccessPermission\AccessPermissionRepository;
use App\Repositories\AccessPermission\IAccessPermissionRepository;
use App\Repositories\Announcement\AnnouncementRepository;
use App\Repositories\Announcement\IAnnouncementRepository;
use App\Repositories\AttachmentFile\AttachmentFileRepository;
use App\Repositories\AttachmentFile\IAttachmentFileRepository;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\Auth\IAuthRepository;
use App\Repositories\AuthenticationHistory\AuthenticationHistoryRepository;
use App\Repositories\AuthenticationHistory\IAuthenticationHistoryRepository;
use App\Repositories\BasicContract\BasicContractRepository;
use App\Repositories\BasicContract\IBasicContractRepository;
use App\Repositories\ChatContent\ChatContentRepository;
use App\Repositories\ChatContent\IChatContentRepository;
use App\Repositories\ChatNotification\ChatNotificationRepository;
use App\Repositories\ChatNotification\IChatNotificationRepository;
use App\Repositories\ChatThread\ChatThreadRepository;
use App\Repositories\ChatThread\IChatThreadRepository;
use App\Repositories\ClientEmployee\ClientEmployeeRepository;
use App\Repositories\ClientEmployee\IClientEmployeeRepository;
use App\Repositories\ClientSite\ClientSiteRepository;
use App\Repositories\ClientSite\IClientSiteRepository;
use App\Repositories\Company\CompanyRepository;
use App\Repositories\Company\ICompanyRepository;
use App\Repositories\CompanyCalendar\CompanyCalendarRepository;
use App\Repositories\CompanyCalendar\ICompanyCalendarRepository;
use App\Repositories\Content\ContentRepository;
use App\Repositories\Content\IContentRepository;
use App\Repositories\ContractCondition\ContractConditionRepository;
use App\Repositories\ContractCondition\IContractConditionRepository;
use App\Repositories\ContractUserSetting\ContractUserSettingRepository;
use App\Repositories\ContractUserSetting\IContractUserSettingRepository;
use App\Repositories\ContractWorkplace\ContractWorkplaceRepository;
use App\Repositories\ContractWorkplace\IContractWorkplaceRepository;
use App\Repositories\Customer\CustomerRepository;
use App\Repositories\Customer\ICustomerRepository;
use App\Repositories\CustomerCategory\CustomerCategoryRepository;
use App\Repositories\CustomerCategory\ICustomerCategoryRepository;
use App\Repositories\Department\DepartmentRepository;
use App\Repositories\Department\IDepartmentRepository;
use App\Repositories\DeviceInformation\DeviceInformationRepository;
use App\Repositories\DeviceInformation\IDeviceInformationRepository;
use App\Repositories\Display\DisplayRepository;
use App\Repositories\Display\IDisplayRepository;
use App\Repositories\Division\DivisionRepository;
use App\Repositories\Division\IDivisionRepository;
use App\Repositories\Employee\EmployeeRepository;
use App\Repositories\Employee\IEmployeeRepository;
use App\Repositories\EventClassification\EventClassificationRepository;
use App\Repositories\EventClassification\IEventClassificationRepository;
use App\Repositories\Facility\FacilityRepository;
use App\Repositories\Facility\IFacilityRepository;
use App\Repositories\FacilityGroup\FacilityGroupRepository;
use App\Repositories\FacilityGroup\IFacilityGroupRepository;
use App\Repositories\FacilityUserSetting\FacilityUserSettingRepository;
use App\Repositories\FacilityUserSetting\IFacilityUserSettingRepository;
use App\Repositories\FAQ\AnswerFileRepository;
use App\Repositories\FAQ\AnswerTextRepository;
use App\Repositories\FAQ\IAnswerFileRepository;
use App\Repositories\FAQ\IAnswerTextRepository;
use App\Repositories\FAQ\IQuestionRepository;
use App\Repositories\FAQ\QuestionRepository;
use App\Repositories\Favorite\FavoriteRepository;
use App\Repositories\Favorite\IFavoriteRepository;
use App\Repositories\Group\GroupRepository;
use App\Repositories\Group\IGroupRepository;
use App\Repositories\IndividualContract\IIndividualContractRepository;
use App\Repositories\IndividualContract\IndividualContractRepository;
use App\Repositories\Layout\ILayoutRepository;
use App\Repositories\Layout\LayoutRepository;
use App\Repositories\ManagementDepartment\IManagementDepartmentRepository;
use App\Repositories\ManagementDepartment\ManagementDepartmentRepository;
use App\Repositories\ManagementGroup\IManagementGroupRepository;
use App\Repositories\ManagementGroup\ManagementGroupRepository;
use App\Repositories\MyCompanyEmployee\IMyCompanyEmployeeRepository;
use App\Repositories\MyCompanyEmployee\MyCompanyEmployeeRepository;
use App\Repositories\Negotiation\INegotiationEmployeeRepository;
use App\Repositories\Negotiation\INegotiationRepository;
use App\Repositories\Negotiation\NegotiationEmployeeRepository;
use App\Repositories\Negotiation\NegotiationRepository;
use App\Repositories\Product\IProductRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Reservation\IReservationRepository;
use App\Repositories\Reservation\ReservationRepository;
use App\Repositories\ScheduleDaily\DailyScheduleRepository;
use App\Repositories\ScheduleDaily\IDailyScheduleRepository;
use App\Repositories\ScheduleTime\ITimeScheduleRepository;
use App\Repositories\ScheduleTime\TimeScheduleRepository;
use App\Repositories\ScheduleWeekly\IWeeklyScheduleRepository;
use App\Repositories\ScheduleWeekly\WeeklyScheduleRepository;
use App\Repositories\Site\ISiteRepository;
use App\Repositories\Site\SiteRepository;
use App\Repositories\SocialData\ISocialDataRepository;
use App\Repositories\SocialData\SocialDataRepository;
use App\Repositories\SocialEvent\ISocialEventRepository;
use App\Repositories\SocialEvent\SocialEventRepository;
use App\Repositories\Supplier\ISupplierRepository;
use App\Repositories\Supplier\SupplierRepository;
use App\Repositories\System\ISystemRepository;
use App\Repositories\System\SystemRepository;
use App\Repositories\Transfer\ITransferRepository;
use App\Repositories\Transfer\TransferRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(IAuthRepository::class, AuthRepository::class);
        $this->app->bind(ISystemRepository::class, SystemRepository::class);
        $this->app->bind(IEmployeeRepository::class, EmployeeRepository::class);
        $this->app->bind(IDepartmentRepository::class, DepartmentRepository::class);
        $this->app->bind(IAccessPermissionRepository::class, AccessPermissionRepository::class);
        $this->app->bind(IAccessHistoryRepository::class, AccessHistoryRepository::class);
        $this->app->bind(IAttachmentFileRepository::class, AttachmentFileRepository::class);
        $this->app->bind(IFavoriteRepository::class, FavoriteRepository::class);
        $this->app->bind(ICompanyRepository::class, CompanyRepository::class);
        $this->app->bind(ISiteRepository::class, SiteRepository::class);
        $this->app->bind(IDivisionRepository::class, DivisionRepository::class);
        $this->app->bind(ITransferRepository::class, TransferRepository::class);
        $this->app->bind(IEventClassificationRepository::class, EventClassificationRepository::class);
        $this->app->bind(IManagementGroupRepository::class, ManagementGroupRepository::class);
        $this->app->bind(IDisplayRepository::class, DisplayRepository::class);
        $this->app->bind(ISupplierRepository::class, SupplierRepository::class);
        $this->app->bind(ICustomerRepository::class, CustomerRepository::class);
        $this->app->bind(IProductRepository::class, ProductRepository::class);
        $this->app->bind(ISocialEventRepository::class, SocialEventRepository::class);
        $this->app->bind(ISocialDataRepository::class, SocialDataRepository::class);
        $this->app->bind(ICustomerCategoryRepository::class, CustomerCategoryRepository::class);
        $this->app->bind(IContentRepository::class, ContentRepository::class);
        $this->app->bind(IQuestionRepository::class, QuestionRepository::class);
        $this->app->bind(IAnswerTextRepository::class, AnswerTextRepository::class);
        $this->app->bind(IAnswerFileRepository::class, AnswerFileRepository::class);
        $this->app->bind(IChatNotificationRepository::class, ChatNotificationRepository::class);
        $this->app->bind(IManagementDepartmentRepository::class, ManagementDepartmentRepository::class);
        $this->app->bind(IMyCompanyEmployeeRepository::class, MyCompanyEmployeeRepository::class);
        $this->app->bind(IClientSiteRepository::class, ClientSiteRepository::class);
        $this->app->bind(IClientEmployeeRepository::class, ClientEmployeeRepository::class);
        $this->app->bind(INegotiationRepository::class, NegotiationRepository::class);
        $this->app->bind(INegotiationEmployeeRepository::class, NegotiationEmployeeRepository::class);
        $this->app->bind(IChatThreadRepository::class, ChatThreadRepository::class);
        $this->app->bind(IChatContentRepository::class, ChatContentRepository::class);
        $this->app->bind(ICompanyCalendarRepository::class, CompanyCalendarRepository::class);
        $this->app->bind(IWeeklyScheduleRepository::class, WeeklyScheduleRepository::class);
        $this->app->bind(IDailyScheduleRepository::class, DailyScheduleRepository::class);
        $this->app->bind(ITimeScheduleRepository::class, TimeScheduleRepository::class);
        $this->app->bind(IGroupRepository::class, GroupRepository::class);
        $this->app->bind(IFacilityGroupRepository::class, FacilityGroupRepository::class);
        $this->app->bind(IFacilityRepository::class, FacilityRepository::class);
        $this->app->bind(IReservationRepository::class, ReservationRepository::class);
        $this->app->bind(IFacilityUserSettingRepository::class, FacilityUserSettingRepository::class);
        $this->app->bind(IAnnouncementRepository::class, AnnouncementRepository::class);
        $this->app->bind(ILayoutRepository::class, LayoutRepository::class);
        $this->app->bind(IAuthenticationHistoryRepository::class, AuthenticationHistoryRepository::class);
        $this->app->bind(IDeviceInformationRepository::class, DeviceInformationRepository::class);
        $this->app->bind(IBasicContractRepository::class, BasicContractRepository::class);
        $this->app->bind(IIndividualContractRepository::class, IndividualContractRepository::class);
        $this->app->bind(IContractConditionRepository::class, ContractConditionRepository::class);
        $this->app->bind(IContractWorkplaceRepository::class, ContractWorkplaceRepository::class);
        $this->app->bind(IContractUserSettingRepository::class, ContractUserSettingRepository::class);
        //:end-bindings:
    }
}
