<?php

namespace App\Enums\AccessHistory;

use BenSampo\Enum\Enum;

final class ResultClassificationEnum extends Enum
{
    const OK = 'OK';
    const DB = 'DB';
    const TABLE = 'TABLE';
    const INPUT = 'INPUT';
    const FILE = 'FILE';
    const DOWNLOAD = 'DOWNLOAD';
    const UPLOAD = 'UPLOAD';
    const SYSTEM = 'SYSTEM';
    const OTHER = 'OTHER';
}
