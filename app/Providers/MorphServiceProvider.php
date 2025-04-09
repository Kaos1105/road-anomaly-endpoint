<?php

namespace App\Providers;

use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Enums\Common\AttachableTypeEnum;
use App\Models\AccessHistory;
use App\Models\AccessPermission;
use App\Models\Announcement;
use App\Models\AnswerFile;
use App\Models\AttachmentFile;
use App\Models\AuthenticationHistory;
use App\Models\BasicContract;
use App\Models\ChatContent;
use App\Models\ChatThread;
use App\Models\ClientEmployee;
use App\Models\ClientSite;
use App\Models\Company;
use App\Models\CompanyCalendar;
use App\Models\Content;
use App\Models\ContractCondition;
use App\Models\ContractUserSetting;
use App\Models\ContractWorkPlace;
use App\Models\Customer;
use App\Models\DailySchedule;
use App\Models\Department;
use App\Models\DeviceInformation;
use App\Models\Display;
use App\Models\Division;
use App\Models\Employee;
use App\Models\EventClassification;
use App\Models\Facility;
use App\Models\FacilityGroup;
use App\Models\FacilityUserSetting;
use App\Models\Favorite;
use App\Models\Group;
use App\Models\IndividualContract;
use App\Models\Login;
use App\Models\ManagementDepartment;
use App\Models\ManagementDepartmentEmployee;
use App\Models\ManagementGroup;
use App\Models\MyCompanyEmployee;
use App\Models\Negotiation;
use App\Models\NegotiationEmployee;
use App\Models\Product;
use App\Models\Question;
use App\Models\Reservation;
use App\Models\Site;
use App\Models\SocialData;
use App\Models\SocialEvent;
use App\Models\Supplier;
use App\Models\System;
use App\Models\TimeSchedule;
use App\Models\Transfer;
use App\Models\WeeklySchedule;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class MorphServiceProvider extends ServiceProvider
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
        Relation::enforceMorphMap([
            AccessibleTypeEnum::EMPLOYEE => Employee::class,
            AccessibleTypeEnum::COMPANY => Company::class,
            AccessibleTypeEnum::SITE => Site::class,
            AccessibleTypeEnum::TRANSFER => Transfer::class,
            AccessibleTypeEnum::DEPARTMENT => Department::class,
            AccessibleTypeEnum::DIVISION => Division::class,
            AccessibleTypeEnum::ATTACHMENT_FILE => AttachmentFile::class,
            AccessibleTypeEnum::FAVORITE => Favorite::class,
            AccessibleTypeEnum::LOGIN => Login::class,
            AccessibleTypeEnum::SYSTEM => System::class,
            AccessibleTypeEnum::ACCESS_PERMISSION => AccessPermission::class,
            AccessibleTypeEnum::ACCESS_HISTORY => AccessHistory::class,
            AccessibleTypeEnum::EVENT_CLASSIFICATION => EventClassification::class,
            AccessibleTypeEnum::MANAGEMENT_GROUP => ManagementGroup::class,
            AccessibleTypeEnum::DISPLAY => Display::class,
            AccessibleTypeEnum::CUSTOMER => Customer::class,
            AccessibleTypeEnum::SUPPLIER => Supplier::class,
            AccessibleTypeEnum::PRODUCT => Product::class,
            AccessibleTypeEnum::SOCIAL_EVENT => SocialEvent::class,
            AccessibleTypeEnum::SOCIAL_DATA => SocialData::class,
            AccessibleTypeEnum::CONTENT => Content::class,
            AccessibleTypeEnum::QUESTION => Question::class,
            AttachableTypeEnum::ANSWER_FILE => AnswerFile::class,
            AccessibleTypeEnum::NEGOTIATION => NEGOTIATION::class,
            AccessibleTypeEnum::MANAGEMENT_DEPARTMENT => ManagementDepartment::class,
            AccessibleTypeEnum::MY_COMPANY_EMPLOYEE => MyCompanyEmployee::class,
            AccessibleTypeEnum::MANAGEMENT_DEPARTMENT_EMPLOYEE => ManagementDepartmentEmployee::class,
            AccessibleTypeEnum::CLIENT_SITE => ClientSite::class,
            AccessibleTypeEnum::CLIENT_EMPLOYEE => ClientEmployee::class,
            AccessibleTypeEnum::NEGOTIATION_EMPLOYEE => NegotiationEmployee::class,
            AttachableTypeEnum::CHAT_CONTENT => ChatContent::class,
            AccessibleTypeEnum::CHAT_THREAD => ChatThread::class,
            AccessibleTypeEnum::WEEKLY_SCHEDULE => WeeklySchedule::class,
            AccessibleTypeEnum::DAILY_SCHEDULE => DailySchedule::class,
            AccessibleTypeEnum::TIME_SCHEDULE => TimeSchedule::class,
            AccessibleTypeEnum::COMPANY_CALENDAR => CompanyCalendar::class,
            AccessibleTypeEnum::GROUP => Group::class,
            AccessibleTypeEnum::FACILITY_GROUP => FacilityGroup::class,
            AccessibleTypeEnum::FACILITY => Facility::class,
            AccessibleTypeEnum::FACILITY_USER_SETTING => FacilityUserSetting::class,
            AccessibleTypeEnum::RESERVATION => Reservation::class,
            AccessibleTypeEnum::ANNOUNCEMENTS => Announcement::class,
            AccessibleTypeEnum::DEVICE_INFORMATION => DeviceInformation::class,
            AccessibleTypeEnum::AUTHENTICATION_HISTORY => AuthenticationHistory::class,
            AccessibleTypeEnum::BASIC_CONTRACT => BasicContract::class,
            AccessibleTypeEnum::INDIVIDUAL_CONTRACT => IndividualContract::class,
            AccessibleTypeEnum::CONTRACT_CONDITION => ContractCondition::class,
            AccessibleTypeEnum::CONTRACT_WORKPLACE => ContractWorkPlace::class,
            AccessibleTypeEnum::CONTRACT_USER_SETTING => ContractUserSetting::class,
        ]);
        //:end-bindings:
    }
}
