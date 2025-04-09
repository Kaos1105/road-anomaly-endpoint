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

    'login_id' => 'ログインID',
    'password' => 'ログインパスワード',

    'common' => [
        'id' => 'ID',
        'note' => '備考',
        'content' => '内容',
        'file_name' => 'ファイル名',
        'file_path' => 'ファイルパス',
        'display_order' => '表示順番号',
        'use_classification' => '使用区分',
        'public_classification' => '公開区分',
        'statistic_classification' => '集計区分',
        'memo' => '備考',
        'created_by' => '新規登録者',
        'updated_by' => '最終更新者',
        'created_at' => '新規登録日時',
        'updated_at' => '最終更新日時',
    ],

    'access_history' => [
        'system_id' => 'システムID',
        'action' => 'Action',
        'accessible_type' => 'Accessible type',
        'accessible_id' => 'Accessible ID',
        'result_classification' => '結果',
    ],

    'system' => [
        'name' => 'システム名',
        'code' => 'CODE',
        'code_old' => 'CODE (OLD)',
        'start_date' => '期間（運用開始）',
        'end_date' => '期間（運用停止）',
        'default_permission_2' => 'Default権限2(編集権限)',
        'default_permission_3' => 'Default権限3(機密閲覧権限)',
        'default_permission_4' => 'Default権限4(所属外閲覧権限)',
    ],

    'access_permission' => [
        'permission_1' => 'アクセス権限',
        'permission_2' => '編集権限',
        'permission_3' => '機密閲覧権限',
        'permission_4' => '所属外閲覧権限',
        'start_date' => '利用開始',
        'end_date' => '利用終了',
    ],

    'login' => [
        'login_id' => 'ログインID',
        'password_decrypt' => 'ログインPASS',
    ],

    'favorite' => [
        'favorable_type' => 'Table名',
        'favorable_id' => 'Record ID',
        'employee_id' => '社員ID',
    ],

    'company' => [
        'table' => '会社',
        'id' => '会社ID',
        'code' => 'CODE',
        'long_name' => '会社名',
        'short_name' => '会社名 (省略名)',
        'kana' => 'よみがな',
        'start_date' => '設立日',
        'end_date' => '解散日',
        'group_name' => '所属グループ名',
        'previous_ name' => '旧会社名',
        'previous_name_flg' => '旧会社名併記フラグ',
        'en_notation' => '英語表記',
        'memo' => '備考',
        'company_classification' => '会社区分',
    ],

    'site' => [
        'table' => '拠点',
        'id' => '拠点ID',
        'code' => 'CODE',
        'long_name' => '拠点名',
        'short_name' => "拠点名  (省略名)",
        'kana' => 'よみがな',
        'start_date' => '設置日',
        'end_date' => '廃止日',
        'represent_flg' => '代表フラグ',
        'site_classification' => '拠点区分',
        'previous_name' => '旧拠点名',
        'previous_name_flg' => '旧名併記フラグ',
        'en_notation' => '英語表記',
        'post_code' => '郵便番号',
        'address_1' => '住所  (都道府県)',
        'address_2' => '住所  (市区町村)',
        'address_3' => '住所  (番地)',
        'phone' => '電話番号',
        'area_name' => '地区名',
        'memo' => '備考',
    ],

    'department' => [
        'table' => '部門',
        'id' => '部門ID',
        'code' => 'CODE',
        'long_name' => '拠点名',
        'short_name' => "拠点名  (省略名)",
        'kana' => 'よみがな',
        'start_date' => '設置日',
        'end_date' => '廃止日',
        'represent_flg' => '代表フラグ',
        'site_classification' => '部門区分',
        'previous_name' => '旧拠点名',
        'previous_name_flg' => '旧名併記フラグ',
        'en_notation' => '英語表記',
        'phone' => '電話番号',
        'memo' => '備考',
        'site_id' => '拠点'
    ],

    'division' => [
        'table' => '課',
        'id' => '課ID',
        'department_id' => '部門ID',
        'code' => 'CODE',
        'long_name' => '課名',
        'short_name' => '課名 (省略名)',
        'kana' => 'よみがな',
        'start_date' => '期間 (設置日)',
        'end_date' => '期間 (廃止日)',
        'division_classification' => '課区分',
        'previous_name' => '旧課門名',
        'previous_name_flg' => '旧名併記',
        'en_notation' => '英語表記',
        'phone' => '電話番号',
        'memo' => '備考',
    ],

    'employee' => [
        'table' => '社員',
        'id' => '社員ID',
        'code' => 'CODE',
        'last_name' => '姓',
        'first_name' => '名',
        'kana' => 'よみがな',
        'day_of_birth' => '期間 (誕生日)',
        'day_of_death' => '期間 (死亡日)',
        'period_accuracy_flg' => '期間正確性',
        'employees_classification' => '社員区分',
        'maiden_name' => '旧姓',
        'previous_name_flg' => '旧姓併記',
        'gender' => '性別',
        'en_notation' => '英語表記',
        'company_email' => '会社メールアドレス',
        'company_phone' => '会社携帯電話番号',
        'post_code' => '郵便番号',
        'address_1' => '住所 (都道府県)',
        'address_2' => '住所 (市町村区)',
        'address_3' => '住所 (番地)',
        'phone' => '電話番号',
        'email' => 'メールアドレス',
        'memo' => '備考',
    ],

    'transfer' => [
        'table' => '人事異動',
        'id' => '人事異動ID',
        'team_name' => '班名',
        'position' => '職制',
        'contract_classification' => '契約区分',
        'start_date' => '期間（開始日）',
        'end_date' => '期間（終了日）',
        'represent_flg' => '会社代表Flag',
        'major_history_flg' => '主要経歴Flag',
        'transfer_classification' => '人事異動区分',
        'memo' => '備考',
    ],

    'event_classification' => [
        'name' => 'イベント区分名',
        'description' => 'イベント説明',
        'operation_rule' => '運用ルール',
        'social_criteria' => '交際基準',
    ],

    'external' => [
        'app_id' => 'アプリケーションID',
        'output_type' => '出力種別',
        'request_id' => 'リクエストID',
        'sentence' => '解析対象テキスト',

    ],

    'management_group' => [
        'id' => '管理グループID',
        'name' => '管理グループ名',
        'sender_post_code' => '差出人郵便番号',
        'sender_address_1' => '住所',
        'sender_address_2' => '住所',
        'sender_address_3' => '住所',
        'sender_name' => '差出人名',
        'contact_point' => '連絡先窓口',
        'contact_phone' => '連絡先電話番号',
        'preparatory_personnel_id' => '準備予定者',
        'applicant_id' => '申請予定者',
        'approver_id' => '承認予定者',
        'final_decision_maker_id' => '決裁予定者',
        'ordering_personnel_id' => '発注予定者',
        'payment_personnel_id' => '支払予定者',
        'completion_personnel_id' => '顧客カテゴリ',
        'category_name' => '顧客カテゴリ名',
    ],

    'supplier' => [
        'sales_store_id' => '店舗名',
        'supplier_classification' => '仕入先区分',
        'supplier_person_id' => '仕入先担当者',
        'my_company_person_id' => '自社担当者',
    ],

    'customer' => [
        'employee_id' => '顧客ID',
        'display_transfer_id' => '表示経歴',
        'responsible_id' => '当社担当',
        'category_name' => '顧客カテゴリ',
        'processing_site' => '経費処理拠点区分',
        'accounting_company' => '経費計上会社区分',
        'accounting_department_id' => '経費計上部門',
        'address_classification' => '住所区分',
        'address_printing_1' => '宛名印刷区分(会社名)',
        'address_printing_2' => '宛名印刷区分(拠点名)',
        'address_printing_3' => '宛名印刷区分(部門名)',
        'address_printing_4' => '宛名印刷区分(課名)',
        'address_printing_5' => '宛名印刷区分(職制)',
        'address_printing_6' => '宛名印刷区分(氏名)',
        'address_printing_7' => '宛名印刷区分(電話番号)',
        'update_order' => '修正指示',
        'specified_address_1' => '指定）都道府県',
        'specified_address_2' => '指定）市町村区',
        'specified_address_3' => '指定）番地',
        'specified_post_code' => '指定）郵便番号',
        'specified_phone' => '指定）電話番号',
    ],

    'product' => [
        'table' => '商品',
        'supplier_id' => '仕入先名',
        'product_classification' => '商品区分',
        'code' => 'CODE',
        'name' => '顧客カテゴリ',
        'unit_price' => '商品単価',
        'tax_classification_1' => '消費税率 (商品)',
        'tax_classification_2' => '消費税率 (送料)',
        'tax_classification_3' => '消費税率 (その他)',
    ],

    'social_event' => [
        'table' => '交際イベント',
        'group_id' => '管理グループ',
        'event_id' => 'イベント区分',
        'event_title' => 'イベントタイトル',
        'event_progress' => 'イベント進捗区分',
        'planned_start' => '開始予定日',
        'creation_deadline' => '起案期限日',
        'approval_deadline' => '決裁期限日',
        'order_deadline' => '発注期限日',
        'planned_completion' => '完了予定日',
        'plan_comment' => 'コメント',
        'actual_comment' => 'コメント',
        'relationship_data' => '交際データ'
    ],

    'social_data' => [
        'table' => '交際データ',
        'customer_id' => '顧客ID',
        'comment_history_suffix' => 'さんが、作成しました。',
        'product_id' => '登録商品',
        'product_name' => '商品名',
        'unit_price' => '商品単価',
        'discount' => '値引き',
        'tax_classification_1' => '消費税率1',
        'tax_1' => '消費税額1',
        'shipping_cost' => '送料',
        'tax_classification_2' => '消費税率2',
        'tax_2' => '消費税額2',
        'other' => 'その他',
        'tax_classification_3' => '消費税率3',
        'tax_3' => '消費税額3',
        'total_amount' => '合計',
        'total_tax' => '消費税額合計',
        'purpose' => '目的（狙い)',
        'result' => '結果（効果）',
        'processing_site' => '経費処理拠点区分',
        'accounting_company' => '経費計上会社区分',
        'accounting_department_id' => '経費計上部門',
        'address_classification' => '住所区分',
        'data_progress' => 'Data進捗区分',
    ],

    'display' => [
        'table' => '画面',
        'code' => 'CODE',
        'display_classification' => '画面区分',
        'name' => '画面名',
        'similar_FAQ' => 'FAQデータ'
    ],

    'content' => [
        'no' => '画面コンテンツNo',
        'classification' => '画面コンテンツ区分',
        'name' => '画面コンテンツ名',
        'permission_1' => '権限 1 (アクセス権限)',
        'permission_2' => '権限２ (編集権限)',
        'permission_3' => '権限３ (機密情報閲覧権限)',
        'permission_4' => '権限４ (所属外閲覧権限)',
    ],


    'workflow' => [
        'execution_type' => '実施区分',
    ],

    'question' => [
        'display_id' => '画面名',
        'code' => 'CODE',
        'classification' => '質問区分',
        'title' => '質問文',
        'permission_2' => '権限２(編集権限)',
        'permission_3' => '権限３(機密情報閲覧権限)',
        'permission_4' => '権限４(所属外閲覧権限)',
        'similar_faq_1_id' => '類似FAQ１',
        'similar_faq_2_id' => '類似FAQ２',
        'similar_faq_3_id' => '類似FAQ３',
    ],

    'answer' => [
        'answer' => '回答',
        'width_size' => '横サイズ（px）',
        'answer_content' => '回答文章',
        'file_content' => 'ファイル',
        'file_name' => 'ファイル名',
    ],

    'chat_content' => [
        'chat_text' => 'Chat内容',
        'chat_classification' => 'Chat区分',
        'employee_id' => 'Chat者',
        'content_classification' => 'Chat内容区分',
    ],

    'management_department' => [
        'table' => '管理部門',
        'id' => '管理部門ID',
        'name' => '管理部門名',
    ],

    'my_company_employee' => [
        'table' => '自社社員',
        'position_classification' => '役割区分',
    ],

    'client_employee' => [
        'table' => '商談履歴',
        'role' => '役割',
    ],

    'negotiation' => [
        'table' => '商談履歴',
        'client_site_id' => '取引先拠点ID',
        'date_time' => '商談日時',
        'progress_classification' => '進捗区分',
        'purpose' => '目的',
        'result' => '商談結果',
        'my_company_employee_ids' => '自社担当者',
        'client_employee_ids' => '取引先担当者',
        'manager_comment' => '上司コメント',
    ],

    'weekly_schedule' => [
        'schedule' => '名前と表示週',
        'display_weekly_classification' => '表示週区分',
        'display_employee_id' => '表示社員（社員ID）',
    ],

    'daily_schedule' => [
        'employee_id' => '利用者',
        'date' => '日付',
        'work_classification' => '勤務区分',
    ],

    'time_schedule' => [
        'employee_id' => '利用者',
        'date' => '日付',
        'start_time' => '開始時刻',
        'end_time' => '終了時刻',
        'work_contents' => '作業内容',
        'work_place' => '作業場所',
        'public_classification' => '公開区分',
        'public_group_id' => '公開グループ',
    ],

    'company_calendar' => [
        'date' => '月日',
        'calendar_classification' => 'カレンダー区分',
        'calendar_content' => '表示内容',
        'work_classification' => '勤務区分',
    ],

    'group' => [
        'name' => 'グループ名',
        'employee_ids' => 'メンバー',
    ],

    'facility_group' => [
        'name' => '設備グループ名',
        'use_group_id' => 'グループ名',
    ],

    'facility' => [
        'table' => '設備',
        'facility_classification' => '設備区分',
        'name' => '設備名',
        'usage_method' => '使用方法',
        'facility_group_id' => '設備グループ名',
        'responsible_user_id' => '利用責任者',
        'aggregation_classification' => '集計区分',
        'reservation' => '設備予約'
    ],

    'facility_user_setting' => [
        'table' => '利用者設定',
        'holiday_display' => '最初に表示する設備グループ'
    ],

    'reservation' => [
        'facility_id' => '設備名',
        'reservation_date' => '日付',
        'start_time' => '開始時刻',
        'end_time' => '終了時刻',
        'work_contents' => '作業内容',
        'use_person_id' => '使用者',
        'regis_time_schedule' => '自分のスケジュール',
    ],

    'excel' => [
        'file' => 'ファイル',
        'system' => 'システム',
        'system_code' => 'システムCODE',
        'display' => '画面名',
        'display_code' => '画面名CODE',
    ],
    'announcement' => [
        'system_id' => 'システム名',
        'display_id' => '画面名',
        'announcement_classification' => 'お知らせ区分',
        'title' => 'お知らせタイトル',
        'content' => 'お知らせ本文',
        'start_time' => '表示期間（開始）',
        'end_time' => '表示期間（終了）',
    ],

    'access_history_table_suffix' => [
        'organization_companies' => '会社',
        'organization_employees' => 'さん',
        'organization_transfers' => 'さんの人事異動情報',
        'organization_sites' => '拠点',
        'organization_departments' => '部門',
        'organization_divisions' => '課',
        'social_event_classifications' => 'イベント区分',
        'social_management_groups' => '管理グループ',
        'social_customers' => '顧客',
        'social_suppliers' => '仕入先',
        'social_products' => '商品',
        'social_social_events' => 'イベント',
        'social_social_datas' => 'さんの交際データ',
        'negotiation_negotiations' => 'の商談履歴',
        'negotiation_management_departments' => '管理部門',
        'negotiation_management_department_employees' => '自社社員',
        'negotiation_client_sites' => '取引先',
        'negotiation_client_employees' => '取引先社員',
        'snet_logins' => 'さんのログイン情報',
        'snet_systems' => '',
        'snet_displays' => '画面',
        'snet_contents' => 'コンテンツ',
        'snet_questions' => '質問',
        'snet_access_permissions' => 'さんの利用権限',
    ],

    'layout' => [
        'system_id' => 'システムID',
        'id' => 'ID',
        'block' => 'Block',
        'content_no' => 'Content No',
        'block_order' => 'Block内順番',
    ],

    'device' => [
        'name' => '端末名',
        'device_information' => '端末情報',
        'device_token' => '端末Token',
        'employee_id' => '社員ID',
        'use_classification' => '使用区分',
    ],

    'basic_contract' => [
        'code' => '契約コード',
        'no' => '契約番号',
        'name' => '契約名',
        'counterparty_id' => '相手先',
        'counterparty_contractor_id' => '相手先契約者',
        'counterparty_representative_id' => '相手先担当者',
        'site_id' => '当社',
        'contractor_id' => '当社契約者',
        'representative_id' => '当社担当者',
        'signing_at' => '契約締結日',
    ],
    'individual_contract' => [
        'basic_contract_id' => '個別契約ID',
        'name' => "社内通称",
        'unit_price' => '単価',
        'unit_classification' => '単位区分',
        'unit_name' => '単位記名',
        'rounding_method' => '丸め方式区分',
        'period_start' => '適用開始',
        'period_end' => '適用終了',
        'table' => '個別契約'
    ],

    'contract_workplace' => [
        'table' => '契約職場',
        'id' => '職場',
        'division_id' => '職場名',
    ],
];
