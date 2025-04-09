<?php

namespace App\Enums\AuthenticationHistory;

use BenSampo\Enum\Enum;

final class AuthenticationActionEnum extends Enum
{
    const AUTHENTICATION1_OK = 'AUTHENTICATION1_OK';
    const AUTHENTICATION1_IDERROR = 'AUTHENTICATION1_IDERROR';
    const AUTHENTICATION1_PASSWORDERROR = 'AUTHENTICATION1_PASSWORDERROR';
    const AUTHENTICATION1_PASSWORDTIMEOUT = 'AUTHENTICATION1_PASSWORDTIMEOUT';
    const AUTHENTICATION2_IMPLEMENT = 'AUTHENTICATION2_IMPLEMENT';
    const AUTHENTICATION2_OK = 'AUTHENTICATION2_OK';
    const AUTHENTICATION2_TOKENERROR = 'AUTHENTICATION2_TOKENERROR';
    const AUTHENTICATION2_TOKENTIMEOUT = 'AUTHENTICATION2_TOKENTIMEOUT';

}
