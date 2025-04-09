<?php

namespace App\Enums\AccessHistory;

use App\Enums\System\SystemCodeEnum;
use BenSampo\Enum\Enum;

final class AccessibleTypeSystemCodeEnum extends Enum
{
    const organization_companies = SystemCodeEnum::ORGANIZATION;
    const organization_employees = SystemCodeEnum::ORGANIZATION;
    const organization_transfers = SystemCodeEnum::ORGANIZATION;
    const organization_sites = SystemCodeEnum::ORGANIZATION;
    const organization_departments = SystemCodeEnum::ORGANIZATION;
    const organization_divisions = SystemCodeEnum::ORGANIZATION;
    const snet_logins = SystemCodeEnum::SNET;
    const snet_systems = SystemCodeEnum::SNET;
    const snet_access_permissions = SystemCodeEnum::SNET;
    const social_event_classifications = SystemCodeEnum::SOCIAL;
    const social_management_groups = SystemCodeEnum::SOCIAL;
    const snet_displays = SystemCodeEnum::SNET;
    const social_customers = SystemCodeEnum::SOCIAL;
    const social_suppliers = SystemCodeEnum::SOCIAL;
    const social_products = SystemCodeEnum::SOCIAL;
    const social_social_events = SystemCodeEnum::SOCIAL;
    const social_social_datas = SystemCodeEnum::SOCIAL;
    const snet_contents = SystemCodeEnum::SNET;
    const snet_announcements = SystemCodeEnum::SNET;
    const snet_questions = SystemCodeEnum::SNET;
    const negotiation_negotiations = SystemCodeEnum::NEGOTIATION;
    const facility_facilities = SystemCodeEnum::FACILITY;
    const main_device_informations = SystemCodeEnum::MAIN;
    const snet_authen_histories = SystemCodeEnum::MAIN;
    const contract_basic_contracts = SystemCodeEnum::CONTRACT;
    const contract_individual_contracts = SystemCodeEnum::CONTRACT;
    const contract_contract_conditions = SystemCodeEnum::CONTRACT;
    const contract_contract_workplaces = SystemCodeEnum::CONTRACT;
    const contract_user_settings = SystemCodeEnum::CONTRACT;
}
