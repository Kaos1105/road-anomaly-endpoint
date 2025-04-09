<?php

namespace App\Services\User;

use App\Repositories\User\IUserRepository;

readonly class UserService implements IUserService
{
    public function __construct(
        private IUserRepository $userRepository,
    ) {
    }

    public function getRepo(): IUserRepository
    {
        return $this->userRepository;
    }

}
