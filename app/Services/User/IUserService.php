<?php

namespace App\Services\User;

use App\Http\DTO\User\LoginData;
use App\Models\User;
use App\Repositories\User\IUserRepository;

interface IUserService
{
    public function getRepo(): IUserRepository;

}
