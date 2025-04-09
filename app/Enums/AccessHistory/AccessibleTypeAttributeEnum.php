<?php

namespace App\Enums\AccessHistory;

use BenSampo\Enum\Enum;

final class AccessibleTypeAttributeEnum extends Enum
{

    const ATTRIBUTES = [
        'organization_companies',
        'organization_employees',
        'organization_transfers',
        'organization_sites',
        'organization_departments',
        'organization_divisions',
        'social_event_classifications',
        'social_management_groups',
        'social_customers',
        'social_suppliers',
        'social_products',
        'social_social_events',
        'social_social_datas',
        'negotiation_negotiations',
        'negotiation_management_departments',
        'negotiation_management_department_employees',
        'negotiation_client_sites',
        'negotiation_client_employees',
        'snet_logins',
        'snet_systems',
        'snet_displays',
        'snet_contents',
        'snet_questions',
        'snet_access_permissions',
    ];

    public static function getConstants(): array
    {
        $constants = [];
        foreach (self::ATTRIBUTES as $attribute) {
            $translation = __('attributes.access_history_table_suffix.' . $attribute);
            $constants[$attribute] = !empty($translation) ? $translation : '';
        }
        return $constants;
    }

}
