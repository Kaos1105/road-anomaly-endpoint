<?php

namespace App\Enums\ScreenName;

use BenSampo\Enum\Enum;

final class ContentNoEnum extends Enum
{
    const COMMON_REGISTRATION_CONTENTS = [
        'SYSTEM_NAME' => '11',
        'HELP' => '14',
        'REGISTRATION' => '17',
        'BACK' => '18',
        'BASIC_INFORMATION' => '21',
    ];
    const COMMON_DISPLAY_HEADER_CONTENTS = [
        'SYSTEM_NAME' => '11',
        'HELP' => '14',
        'DELETE' => '16',
        'EDIT' => '17',
        'BACK' => '18',
    ];

    const COMPANY_DISPLAY_CONTENTS = [
        'ORGANIZATION_CHART' => '15',
        'BASIC_INFORMATION' => '21',
        'SITE_INFORMATION' => '31',
        'SITE_REGISTRATION' => '32',
        'SITE_REPRESENTATIVE' => '33',
        'SITE_DISPLAY' => '34',
        'EMPLOYEE_INFORMATION' => '41',
        'EMPLOYEE_REPRESENTATIVE' => '42',
        'EMPLOYEE_DISPLAY' => '43',
        'FILE' => '51',
        'FILE_ADD_PASTE_DELETE' => '52',
    ];

    const SITE_DISPLAY_CONTENTS = [
        'ORGANIZATION_CHART' => '15',
        'BASIC_INFORMATION' => '21',
        'DEPARTMENT_REGISTRATION' => '22',
        'DEPARTMENT_INFORMATION' => '31',
        'DEPARTMENT_REPRESENTATIVE' => '32',
        'DEPARTMENT_DISPLAY' => '33',
        'EMPLOYEE_INFORMATION' => '41',
        'EMPLOYEE_REGISTRATION' => '42',
        'EMPLOYEE_DISPLAY' => '43',
        'FILE_AREA' => '51',
        'FILE_ADD_PASTE_DELETE' => '52',
    ];

    const DEPARTMENT_DISPLAY_CONTENTS = [
        'ORGANIZATION_CHART' => '15',
        'BASIC_INFORMATION' => '21',
        'DIVISION_INFORMATION' => '31',
        'DIVISION_REGISTRATION' => '32',
        'DIVISION_REPRESENTATIVE' => '33',
        'DIVISION_DISPLAY' => '34',
        'EMPLOYEE_INFORMATION' => '41',
        'EMPLOYEE_REGISTRATION' => '42',
        'EMPLOYEE_DISPLAY' => '44',
        'FILE' => '51',
        'FILE_ADD_PASTE_DELETE' => '52',
    ];

    const EMPLOYEE_DISPLAY_CONTENTS = [
        'BASIC_INFORMATION' => '21',
        'PRIVATE_INFORMATION' => '31',
        'EMPLOYEE_INFORMATION' => '41',
        'TRANSFER_EDIT' => '42',
        'TRANSFER_COPY' => '43',
        'TRANSFER_DELETE' => '44',
        'FILE' => '51',
        'FILE_ADD_PASTE_DELETE' => '52',
    ];

    const EVENT_CLASSIFICATION_DISPLAY_CONTENTS = [
        'BASIC_INFORMATION' => '21',
        'SOCIAL_EVENT_RESULT' => '31',
    ];

    const MANAGEMENT_GROUP_DISPLAY_CONTENTS = [
        'BASIC_INFORMATION' => '21',
        'WORKFLOW_PROCESSOR' => '31',
        'CUSTOMER_CATEGORY' => '41',
        'SOCIAL_EVENT_RESULT' => '51',
    ];

    const CUSTOMER_DISPLAY_CONTENTS = [
        'BASIC_INFORMATION' => '21',
        'MAJOR_HISTORY' => '31',
        'SOCIAL_ACTUAL_ALL' => '41',
    ];

    const SUPPLIER_DISPLAY_CONTENTS = [
        'BASIC_INFORMATION' => '21',
        'TRANSACTION_HISTORY' => '31',
        'PRODUCT_ORDER_HISTORY' => '41',
        'ADD' => '42',
        'PRODUCT_LIST' => '51',
    ];

    const PRODUCT_DISPLAY_CONTENTS = [
        'BASIC_INFORMATION' => '21',
        'ORDER_HISTORY' => '31',
    ];

    const SOCIAL_EVENT_DISPLAY_CONTENTS = [
        'ORDER_LIST' => '12',
        'SOCIAL_DATA' => '13',
        'BASIC_INFORMATION' => '21',
        'PLAN' => '31',
        'PROGRESS' => '41',
        'RESULT' => '51',
    ];

    const SOCIAL_DATA_DISPLAY_CONTENTS = [
        'BASIC_INFORMATION' => '21',
        'ORDER_HISTORY' => '31',
    ];

    const ACCESS_PERMISSION_ADD_CONTENTS = [
        'USER_INFORMATION' => '31',
        'ACCESS_PERMISSION' => '41',
    ];

    const HELP_FAQ_EDIT_CONTENTS = [
        'BASIC_INFORMATION' => '21',
        'ANSWER' => '31',
    ];

    const SCREEN_DISPLAY_CONTENTS = [
        'CONTENT_ADD' => '34',
        'CONTENT_DELETE' => '33',
        'CONTENT_EDIT' => '32',
    ];

    const FACILITY_MANAGEMENT_DASHBOARD = [
        'CALENDAR' => '31',
    ];

    public static function getContentNo(array $screenContents, string $contentName): ?string
    {
        return $screenContents[$contentName] ?? null;
    }

}
