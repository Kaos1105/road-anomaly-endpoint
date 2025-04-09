<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Message Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the Laravel Responder package.
    | When it generates responses, it will search the messages array
    | below for any key matching the given code for the response.
    |
    */

    'delete_success' => '削除しました。',
    'delete_unsuccessful' => '削除に失敗しました。',
    'create_success' => '登録しました。',
    'create_unsuccessful' => '作成に失敗しました。',
    'update_success' => '更新しました。',
    'update_unsuccessful' => '更新に失敗しました。',
    'token_revoked' => 'Token Revoked',
    'no_content' => 'コンテンツなし。',
    'negotiation' => [
        'can_not_access_history' => '現在、ご利用いただけません。システム管理者にお問い合わせください。'
    ],
    'schedule' => [
        'warming_company_calendar' => '会社カレンダーを設定してください。'
    ],

    'facility' => [
        'no_facility_group' => "設備グループが登録されていないため、利用できません。",
        'no_user_setting' => "利用者設定をしてください。"
    ],

    'excel' => [
        'error_record' => '正しい形式ではないレコードが:record件あります。',
        'success_record' => '処理されたレコードが:record件あります。',
    ],

    'unavailable_system' => 'ただいま、システムはメンテナンス中のため、使用できません。',

    'authentication' => [
        'AUTHENTICATION1_OK' => 'さんのIDとパスワードが合っています。',
        'AUTHENTICATION1_IDERROR' => '不明のアクセス',
        'AUTHENTICATION1_PASSWORDERROR' => 'さんのパスワードが間違いました。',
        'AUTHENTICATION1_PASSWORDTIMEOUT' => 'さんのパスワードの期限が切れました。',
        'AUTHENTICATION2_OK' => 'の二要素認証が成功しました。',
        'AUTHENTICATION2_IMPLEMENT' => 'の二要素認証が成功しました。',
        'TWO_FACTOR' => 'さんのの二要素認証が成功しました。',
        'AUTHENTICATION2_TOKENTIMEOUT' => 'さんの二要素認証のTokenの期限が切れました。',
        'AUTHENTICATION2_TOKENERROR' => 'さんの二要素認証のTokenが間違いました。',
    ]
];
