<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Error Message Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the Laravel Responder package.
    | When it generates error responses, it will search the messages array
    | below for any key matching the given error code for the response.
    |
    */

    'unauthenticated' => 'パスワードが正しくありません。',
    'login_id_invalid' => 'ログインＩＤまたはパスワードに誤りがあります。',
    'unauthorized' => 'アクセスが拒否されました。',
    'incorrect_login' => 'ログイン情報が間違っています。',
    'account_locked.' => 'アカウントがロックされました。',
    'page_not_found' => 'ページが見つかりません。',
    'relation_not_found' => 'リクエストしたリレーションが存在しません。',
    'validation_failed' => 'バリデーションエラーがあります。',
    'url' => 'URLが正しくありません。',
    'can_not_delete' => 'このデータは:attr1が登録されているため削除できません。',
    'forbidden' => 'この行為は禁止されています。',
    'service_unavailable' => '現在、ご利用いただけません。システム管理者にお問い合わせください。',
    'social_data_cant_delete' => 'この交際データは承認されているため、削除できません。進捗状況を申請済みまで差戻してください。',
    'can_not_delete_fqa' => 'このデータは別の質問で類似FAQとして登録されているため削除できません。',
    'upload_file_fail' => '処理が異常終了しました。.',
    'excel' => [
        'file_type' => 'Excel形式ではありません。Excel形式で登録してください。',
        'template' => 'テンプレートが間違えています。Excelファイルを修正してください。',
        'no_data' => 'Excelファイルにデータが入っていません。Excelファイルを修正してください。'
    ],
    'main' => [
        '2004' => 'パスワードの期限が切れています。システム管理者にお問い合わせください。',
        '2005' => 'メールが登録されていないため、二要素認証を実行できません。システム管理者にお問い合わせください。',
        '10004' => '大変申し訳ございません。二要素認証が失敗したので、管理者に連絡してください。'
    ]
];
