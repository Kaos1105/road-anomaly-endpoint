<?php

namespace App\Enums\AccessHistory;

use BenSampo\Enum\Enum;

final class AccessibleTypeEnum extends Enum
{
    const COMPANY = 'organization_companies';
    const EMPLOYEE = 'organization_employees';
    const TRANSFER = 'organization_transfers';
    const SITE = 'organization_sites';
    const DEPARTMENT = 'organization_departments';
    const DIVISION = 'organization_divisions';
    const ATTACHMENT_FILE = 'common_attachment_files';
    const FAVORITE = 'common_favorites';
    const LOGIN = 'snet_logins';
    const SYSTEM = 'snet_systems';
    const ACCESS_PERMISSION = 'snet_access_permissions';
    const ACCESS_HISTORY = 'snet_access_histories';
    const EVENT_CLASSIFICATION = 'social_event_classifications';
    const MANAGEMENT_GROUP = 'social_management_groups';
    const DISPLAY = 'snet_displays';
    const CUSTOMER = 'social_customers';
    const SUPPLIER = 'social_suppliers';
    const PRODUCT = 'social_products';
    const SOCIAL_EVENT = 'social_social_events';
    const SOCIAL_DATA = 'social_social_datas';
    const CONTENT = 'snet_contents';
    const QUESTION = 'snet_questions';
    const CHAT_THREAD = 'snet_chat_threads';
    const ANNOUNCEMENTS = 'snet_announcements';
    const NEGOTIATION = 'negotiation_negotiations';
    const MANAGEMENT_DEPARTMENT = 'negotiation_management_departments';
    const MY_COMPANY_EMPLOYEE = 'negotiation_my_company_employees';
    const MANAGEMENT_DEPARTMENT_EMPLOYEE = 'negotiation_management_department_employees';
    const CLIENT_SITE = 'negotiation_client_sites';
    const CLIENT_EMPLOYEE = 'negotiation_client_employees';
    const NEGOTIATION_EMPLOYEE = 'negotiation_negotiation_employees';
    const WEEKLY_SCHEDULE = 'schedule_weekly_schedule';
    const DAILY_SCHEDULE = 'schedule_daily_schedule';
    const TIME_SCHEDULE = 'schedule_time_schedule';
    const COMPANY_CALENDAR = 'schedule_company_calendar';
    const GROUP = 'main_groups';
    const FACILITY_GROUP = 'facility_facility_groups';
    const FACILITY = 'facility_facilities';
    const FACILITY_USER_SETTING = 'facility_user_settings';
    const RESERVATION = 'facility_reservations';
    const DEVICE_INFORMATION = 'main_device_informations';
    const AUTHENTICATION_HISTORY = 'snet_authen_histories';
    const BASIC_CONTRACT = 'contract_basic_contracts';
    const INDIVIDUAL_CONTRACT = 'contract_individual_contracts';
    const CONTRACT_CONDITION = 'contract_contract_conditions';
    const CONTRACT_WORKPLACE = 'contract_contract_workplaces';
    const CONTRACT_USER_SETTING = 'contract_user_settings';
}
