<?php

namespace App\Enums\Common;

use BenSampo\Enum\Enum;

final class AttachableTypeEnum extends Enum
{
    const EMPLOYEE = 'organization_employees';

    const COMPANY = 'organization_companies';

    const SITE = 'organization_sites';

    const DEPARTMENT = 'organization_departments';

    const DIVISION = 'organization_divisions';

    const ANSWER_FILE = 'snet_answer_files';

    const NEGOTIATION = 'negotiation_negotiations';

    const CHAT_CONTENT = 'snet_chat_contents';

    const PRODUCT = 'social_products';

    const FACILITY = 'facility_facilities';

    const BASIC_CONTRACT = 'contract_basic_contracts';

    const INDIVIDUAL_CONTRACT = 'contract_individual_contracts';
}
