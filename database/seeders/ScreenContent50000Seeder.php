<?php

namespace Database\Seeders;

use App\Enums\AccessPermission\Permission1FlagEnum;
use App\Enums\AccessPermission\Permission2FlagEnum;
use App\Enums\AccessPermission\Permission3FlagEnum;
use App\Enums\AccessPermission\Permission4FlagEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\ScreenName\ContentClassificationEnum;
use App\Enums\ScreenName\DisplayClassificationEnum;
use App\Enums\System\SystemCodeEnum;
use App\Models\AccessPermission;
use App\Models\Display;
use App\Models\Employee;
use App\Models\Login;
use App\Models\System;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ScreenContent50000Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $login = Login::where('login_id', env('DEPLOY_LOGIN_ID'))->first();
        $scheduleSystem = System::updateOrCreate(['code' => SystemCodeEnum::SCHEDULE,
        ], [
            'name' => '予定管理システム',
            'start_date' => Carbon::now(),
            'default_permission_2' => Permission2FlagEnum::DATA_VIEWING,
            'default_permission_3' => Permission3FlagEnum::GENERAL_INFORMATION,
            'default_permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION,
            'use_classification' => UseFlagEnum::USE,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id
        ]);

        $employees = Employee::query()->has('logins')->get();
        $existedAccessPermissions = AccessPermission::query()->where('system_id', $scheduleSystem->id);
        if (!$existedAccessPermissions->count()) {
            $employees->each(function (Employee $employee) use ($scheduleSystem) {
                AccessPermission::create([
                    'employee_id' => $employee->id,
                    'system_id' => $scheduleSystem->id,
                    'permission_1' => Permission1FlagEnum::UN_AUTHORIZED_USER,
                    'permission_2' => $scheduleSystem->default_permission_2,
                    'permission_3' => $scheduleSystem->default_permission_3,
                    'permission_4' => $scheduleSystem->default_permission_4,
                    'start_date' => $scheduleSystem->start_date,
                ]);
            });
        }

        // Display
        Display::upsert([
            ['system_id' => $scheduleSystem->id, 'code' => '50000', 'name' => 'ダッシュボード', 'display_classification' => DisplayClassificationEnum::DASHBOARD, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['system_id' => $scheduleSystem->id, 'code' => '50100', 'name' => 'スケジュール検索', 'display_classification' => DisplayClassificationEnum::OTHER, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['system_id' => $scheduleSystem->id, 'code' => '51000', 'name' => '週間スケジュール設定', 'display_classification' => DisplayClassificationEnum::OTHER, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['system_id' => $scheduleSystem->id, 'code' => '52000', 'name' => '会社カレンダー設定', 'display_classification' => DisplayClassificationEnum::OTHER, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
//            ['system_id' => $scheduleSystem->id, 'code' => 'Z50100', 'name' => '利用権限一覧', 'display_classification' => DisplayClassificationEnum::LIST, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' =>$login?->employee_id],
//            ['system_id' => $scheduleSystem->id, 'code' => 'Z50130', 'name' => '利用権限設定', 'display_classification' => DisplayClassificationEnum::OTHER, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' =>$login?->employee_id],
        ], ['code']);

        // Content
        $screen = Display::where('code', '50000')->first();
        $screen?->contents()->delete();
        $screen?->contents()->createMany([
            ['no' => '11', 'name' => 'システム名', 'classification' => ContentClassificationEnum::TITLE, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '14', 'name' => 'ヘルプ', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '10', 'name' => 'Chat問合せ', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '15', 'name' => '利用者', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '16', 'name' => '検索', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '19', 'name' => '週間設定', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '18', 'name' => '戻る', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '21', 'name' => 'カレンダー', 'classification' => ContentClassificationEnum::TOPIC, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '22', 'name' => '社員', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '31', 'name' => 'トピックス', 'classification' => ContentClassificationEnum::CARD, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '32', 'name' => '利用者権限設定', 'classification' => ContentClassificationEnum::CARD, 'permission_1' => Permission1FlagEnum::SYSTEM_MANAGER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '33', 'name' => '利用者権限設定', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_MANAGER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '34', 'name' => 'お知らせ管理', 'classification' => ContentClassificationEnum::CARD, 'permission_1' => Permission1FlagEnum::SYSTEM_MANAGER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '35', 'name' => 'お知らせ登録', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_MANAGER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
        ]);

        $screen = Display::where('code', '50100')->first();
        $screen?->contents()->delete();
        $screen?->contents()->createMany([
            ['no' => '11', 'name' => 'システム名', 'classification' => ContentClassificationEnum::TITLE, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '14', 'name' => 'ヘルプ', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '10', 'name' => 'Chat問合せ', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '18', 'name' => '戻る', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '21', 'name' => '検索', 'classification' => ContentClassificationEnum::CARD, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '31', 'name' => 'スケジュール一覧 ', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '32', 'name' => '表示', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
        ]);

        $screen = Display::where('code', '51000')->first();
        $screen?->contents()->delete();
        $screen?->contents()->createMany([
            ['no' => '11', 'name' => 'システム名', 'classification' => ContentClassificationEnum::TITLE, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '14', 'name' => 'ヘルプ', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '10', 'name' => 'Chat問合せ', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '17', 'name' => '登録', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '18', 'name' => '戻る', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '21', 'name' => '週間スケジュール設定', 'classification' => ContentClassificationEnum::CARD, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '31', 'name' => '追加', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '32', 'name' => '削除', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
        ]);

        $screen = Display::where('code', '52000')->first();
        $screen?->contents()->delete();
        $screen?->contents()->createMany([
            ['no' => '11', 'name' => 'システム名', 'classification' => ContentClassificationEnum::TITLE, 'permission_1' => Permission1FlagEnum::SYSTEM_MANAGER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '14', 'name' => 'ヘルプ', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_MANAGER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '10', 'name' => 'Chat問合せ', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_MANAGER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '17', 'name' => '登録', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_MANAGER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '18', 'name' => '戻る', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_MANAGER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '21', 'name' => '会社カレンダー設定', 'classification' => ContentClassificationEnum::CARD, 'permission_1' => Permission1FlagEnum::SYSTEM_MANAGER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '31', 'name' => '追加', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_MANAGER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '32', 'name' => '削除', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_MANAGER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
        ]);

    }
}
