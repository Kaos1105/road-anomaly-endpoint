<?php

namespace App\Providers;

use App\Models\AccessPermission;
use App\Models\Announcement;
use App\Models\ChatContent;
use App\Models\ClientEmployee;
use App\Models\ClientSite;
use App\Models\CompanyCalendar;
use App\Models\Content;
use App\Models\Customer;
use App\Models\DailySchedule;
use App\Models\Display;
use App\Models\EventClassification;
use App\Models\Facility;
use App\Models\FacilityGroup;
use App\Models\FacilityUserSetting;
use App\Models\Group;
use App\Models\IndividualContract;
use App\Models\ManagementDepartment;
use App\Models\ManagementGroup;
use App\Models\MyCompanyEmployee;
use App\Models\Negotiation;
use App\Models\Product;
use App\Models\Question;
use App\Models\Reservation;
use App\Models\SocialData;
use App\Models\SocialEvent;
use App\Models\Supplier;
use App\Models\System;
use App\Models\Company;
use App\Models\Department;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Site;
use App\Models\TimeSchedule;
use App\Models\Transfer;
use App\Models\WeeklySchedule;
use App\Policies\AnnouncementPolicy;
use App\Policies\ChatContentPolicy;
use App\Policies\ClientEmployeePolicy;
use App\Policies\ClientSitePolicy;
use App\Policies\CompanyCalendarPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\ContentPolicy;
use App\Policies\CustomerPolicy;
use App\Policies\DailySchedulePolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\DisplayPolicy;
use App\Policies\DivisionPolicy;
use App\Policies\EmployeePolicy;
use App\Policies\EventClassificationPolicy;
use App\Policies\FacilityGroupPolicy;
use App\Policies\FacilityPolicy;
use App\Policies\FacilityUserSettingPolicy;
use App\Policies\GroupPolicy;
use App\Policies\ManagementDepartmentPolicy;
use App\Policies\ManagementGroupPolicy;
use App\Policies\MyCompanyEmployeePolicy;
use App\Policies\NegotiationPolicy;
use App\Policies\ProductPolicy;
use App\Policies\QuestionPolicy;
use App\Policies\ReservationPolicy;
use App\Policies\SitePolicy;
use App\Policies\SocialDataPolicy;
use App\Policies\SocialEventPolicy;
use App\Policies\SupplierPolicy;
use App\Policies\TimeSchedulePolicy;
use App\Policies\TransferPolicy;
use App\Policies\AccessPermissionPolicy;
use App\Policies\SystemPolicy;
use App\Policies\WeeklySchedulePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        System::class => SystemPolicy::class,
        AccessPermission::class => AccessPermissionPolicy::class,
        Company::class => CompanyPolicy::class,
        Site::class => SitePolicy::class,
        Department::class => DepartmentPolicy::class,
        Division::class => DivisionPolicy::class,
        Employee::class => EmployeePolicy::class,
        Transfer::class => TransferPolicy::class,
        EventClassification::class => EventClassificationPolicy::class,
        ManagementGroup::class => ManagementGroupPolicy::class,
        Supplier::class => SupplierPolicy::class,
        Customer::class => CustomerPolicy::class,
        Product::class => ProductPolicy::class,
        SocialEvent::class => SocialEventPolicy::class,
        SocialData::class => SocialDataPolicy::class,
        Display::class => DisplayPolicy::class,
        Content::class => ContentPolicy::class,
        Question::class => QuestionPolicy::class,
        Announcement::class => AnnouncementPolicy::class,
        ManagementDepartment::class => ManagementDepartmentPolicy::class,
        MyCompanyEmployee::class => MyCompanyEmployeePolicy::class,
        ClientSite::class => ClientSitePolicy::class,
        ClientEmployee::class => ClientEmployeePolicy::class,
        Negotiation::class => NegotiationPolicy::class,
        ChatContent::class => ChatContentPolicy::class,
        TimeSchedule::class => TimeSchedulePolicy::class,
        DailySchedule::class => DailySchedulePolicy::class,
        WeeklySchedule::class => WeeklySchedulePolicy::class,
        CompanyCalendar::class => CompanyCalendarPolicy::class,
        Group::class => GroupPolicy::class,
        FacilityGroup::class => FacilityGroupPolicy::class,
        Facility::class => FacilityPolicy::class,
        Reservation::class => ReservationPolicy::class,
        FacilityUserSetting::class => FacilityUserSettingPolicy::class,
    ];


    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
