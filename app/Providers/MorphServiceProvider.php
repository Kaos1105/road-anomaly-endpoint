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
           
        ]);
        //:end-bindings:
    }
}
