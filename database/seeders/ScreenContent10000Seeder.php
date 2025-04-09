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

class ScreenContent10000Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $login = Login::where('login_id', env('DEPLOY_LOGIN_ID'))->first();
        // System
        $mainSystem = System::updateOrCreate(
            ['code' => SystemCodeEnum::MAIN], [
            'name' => 'S-NET',
            'start_date' => Carbon::now(),
            'default_permission_2' => Permission2FlagEnum::DATA_VIEWING,
            'default_permission_3' => Permission3FlagEnum::GENERAL_INFORMATION,
            'default_permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION,
            'use_classification' => UseFlagEnum::USE,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'created_by' => $login?->employee_id,
            'updated_by' => $login?->employee_id
        ]);

        // Access Permission
        $employees = Employee::query()->has('logins')->get();
        $existedAccessPermissions = AccessPermission::query()->where('system_id', $mainSystem->id);
        if (!$existedAccessPermissions->count()) {
            $employees->each(function (Employee $employee) use ($mainSystem) {
                AccessPermission::create([
                    'employee_id' => $employee->id,
                    'system_id' => $mainSystem->id,
                    'permission_1' => Permission1FlagEnum::UN_AUTHORIZED_USER,
                    'permission_2' => $mainSystem->default_permission_2,
                    'permission_3' => $mainSystem->default_permission_3,
                    'permission_4' => $mainSystem->default_permission_4,
                    'start_date' => $mainSystem->start_date,
                ]);
            });
        }

        // Display
        Display::upsert([
            ['system_id' => $mainSystem->id, 'code' => '10001', 'name' => 'ログイン', 'display_classification' => DisplayClassificationEnum::OTHER, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id,],
            ['system_id' => $mainSystem->id, 'code' => '10000', 'name' => 'ポータル', 'display_classification' => DisplayClassificationEnum::DASHBOARD, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['system_id' => $mainSystem->id, 'code' => '10100', 'name' => '設定', 'display_classification' => DisplayClassificationEnum::OTHER, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['system_id' => $mainSystem->id, 'code' => '10200', 'name' => 'グループ登録', 'display_classification' => DisplayClassificationEnum::OTHER, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['system_id' => $mainSystem->id, 'code' => '10300', 'name' => 'グループ登録', 'display_classification' => DisplayClassificationEnum::LIST, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['system_id' => $mainSystem->id, 'code' => '11000', 'name' => 'ハザードマップ情報', 'display_classification' => DisplayClassificationEnum::DISPLAY, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['system_id' => $mainSystem->id, 'code' => '11020', 'name' => 'ハザードマップ追加', 'display_classification' => DisplayClassificationEnum::ADD, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id]
        ], ['code']);

        // Content
        $screen = Display::where('code', '10000')->first();
        $screen?->contents()->delete();
        $screen?->contents()->createMany([
            ['no' => '11', 'name' => 'システム名', 'classification' => ContentClassificationEnum::TITLE, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '14', 'name' => 'ヘルプ', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '10', 'name' => 'Chat問合せ', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '13', 'name' => '顔写真', 'classification' => ContentClassificationEnum::OTHER, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '15', 'name' => '利用者', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '16', 'name' => '設定', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '19', 'name' => 'ログアウト', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '21', 'name' => '週間カレンダー', 'classification' => ContentClassificationEnum::TOPIC, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '31', 'name' => 'トピックス', 'classification' => ContentClassificationEnum::CARD, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '32', 'name' => '利用者権限設定', 'classification' => ContentClassificationEnum::CARD, 'permission_1' => Permission1FlagEnum::SYSTEM_MANAGER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id,],
            ['no' => '33', 'name' => '利用者権限設定', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_MANAGER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id,],
            ['no' => '34', 'name' => 'お知らせ管理', 'classification' => ContentClassificationEnum::CARD, 'permission_1' => Permission1FlagEnum::SYSTEM_MANAGER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id,],
            ['no' => '35', 'name' => 'お知らせ登録', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_MANAGER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id,],
            ['no' => '51', 'name' => 'QC活動支援システム', 'classification' => ContentClassificationEnum::CARD, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id,],
            ['no' => '52', 'name' => '起動する', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id,],
            ['no' => '53', 'name' => '組織管理', 'classification' => ContentClassificationEnum::CARD, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id,],
            ['no' => '54', 'name' => '起動する', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '55', 'name' => 'S-NET管理', 'classification' => ContentClassificationEnum::CARD, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id,],
            ['no' => '56', 'name' => '起動する', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id,],
            ['no' => '57', 'name' => '交際管理', 'classification' => ContentClassificationEnum::CARD, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id,],
            ['no' => '58', 'name' => '起動する', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id,],
            ['no' => '59', 'name' => '商談管理', 'classification' => ContentClassificationEnum::CARD, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id,],
            ['no' => '60', 'name' => '起動する', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id,],
            ['no' => '61', 'name' => '予定管理', 'classification' => ContentClassificationEnum::CARD, 'permission_1' => Permission1FlagEnum::SYSTEM_MANAGER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id,],
            ['no' => '62', 'name' => '会社カレンダー設定', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_MANAGER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id,],
            ['no' => '63', 'name' => '設備予約', 'classification' => ContentClassificationEnum::CARD, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id,],
            ['no' => '64', 'name' => '設備を予約する', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id,],
            ['no' => '65', 'name' => '設備グループ登録', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_MANAGER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id,],
            ['no' => '66', 'name' => '契約管理', 'classification' => ContentClassificationEnum::CARD, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id,],
            ['no' => '67', 'name' => '起動する', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id,],
        ]);

        $screen = Display::where('code', '10001')->first();
        $screen?->contents()->delete();
        $screen?->contents()->createMany([
            ['no' => '21', 'name' => 'S-NET', 'classification' => ContentClassificationEnum::TITLE, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '31', 'name' => 'システムからのお知らせ', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '33', 'name' => 'システムの注意', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '41', 'name' => 'ログインフォーム', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
        ]);

        $screen = Display::where('code', '10200')->first();
        $screen?->contents()->delete();
        $screen?->contents()->createMany([
            ['no' => '11', 'name' => 'システム名', 'classification' => ContentClassificationEnum::TITLE, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '14', 'name' => 'ヘルプ', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '10', 'name' => 'Chat問合せ', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '17', 'name' => '追加', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '18', 'name' => '戻る', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '21', 'name' => '検索', 'classification' => ContentClassificationEnum::SEARCH_FIELD, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '31', 'name' => 'グループ一覧', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '32', 'name' => '修正', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '33', 'name' => '複写', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
        ]);

        $screen = Display::where('code', '10100')->first();
        $screen?->contents()->delete();
        $screen?->contents()->createMany([
            ['no' => '11', 'name' => 'システム名', 'classification' => ContentClassificationEnum::TITLE, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '14', 'name' => 'ヘルプ', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '10', 'name' => 'Chat問合せ', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '18', 'name' => '戻る', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '21', 'name' => '設定情報', 'classification' => ContentClassificationEnum::LIST, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '22', 'name' => '端末登録', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '23', 'name' => 'グループ登録', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
        ]);

        $screen = Display::where('code', '10300')->first();
        $screen?->contents()->delete();
        $screen?->contents()->createMany([
            ['no' => '11', 'name' => 'システム名', 'classification' => ContentClassificationEnum::TITLE, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '14', 'name' => 'ヘルプ', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '10', 'name' => 'Chat問合せ', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '17', 'name' => 'この端末で通知を受信する', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '18', 'name' => '戻る', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '21', 'name' => '検索', 'classification' => ContentClassificationEnum::SEARCH_FIELD, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '31', 'name' => '端末一覧', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '32', 'name' => '削除', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
            ['no' => '33', 'name' => '修正', 'classification' => ContentClassificationEnum::BUTTON, 'permission_1' => Permission1FlagEnum::SYSTEM_USER, 'permission_2' => Permission2FlagEnum::DATA_VIEWING, 'permission_3' => Permission3FlagEnum::GENERAL_INFORMATION, 'permission_4' => Permission4FlagEnum::AFFILIATED_DIVISION, 'use_classification' => UseFlagEnum::USE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => $login?->employee_id, 'updated_by' => $login?->employee_id],
        ]);
    }
}
