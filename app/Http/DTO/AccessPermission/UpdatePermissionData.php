<?php

declare(strict_types=1);

namespace App\Http\DTO\AccessPermission;

use App\Models\Login;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class UpdatePermissionData extends SharedPermissionData
{
    public function __construct(
        public int  $id,
        public int  $employeeId,
        public int  $systemId,
        public int  $permission_2,
        public int  $permission_3,
        public int  $permission_4,
        public ?int $updatedBy,
    )
    {
        parent::__construct($this->employeeId);
        /*** @var $login Login
         */
        $login = \Auth::user();
        $this->updatedBy = $login->employee_id;
    }
}
