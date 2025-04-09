<?php

namespace App\Enums\AccessHistory;

use BenSampo\Enum\Enum;

final class AccessActionTypeEnum extends Enum
{
    const LOGIN = 'LOGIN';
    const LOGOUT = 'LOGOUT';
    const START = 'START';
    const LIST = 'LIST';
    const VIEW = 'VIEW';
    const CREATE = 'CREATE';
    const EDIT = 'EDIT';
    const COMMENT = 'COMMENT';
    const DELETE = 'DELETE';
    const DOWNLOAD = 'DOWNLOAD';
    const UPLOAD = 'UPLOAD';
    const PRINT = 'PRINT';
    const INSERT_PRINT = 'INSERT_PRINT';
    const HELP = 'HELP';
    const SEARCH = 'SEARCH';
    const USER_VIEW_QUESTION = 'USER_VIEW_QUESTION';
    const CHAT_LIST = 'CHAT_LIST';
    const ADMIN_VIEW_CHAT = 'ADMIN_VIEW_CHAT';
    const USER_VIEW_CHAT = 'USER_VIEW_CHAT';
    const ADMIN_CHAT = 'ADMIN_CHAT';
    const USER_CHAT = 'USER_CHAT';
    const SUMMARY = 'SUMMARY';
    const SETTING = 'SETTING';
    const APPROVAL = 'APPROVAL';
}
