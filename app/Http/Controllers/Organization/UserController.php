<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\User\UpsertUserRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserItemResource;
use App\Models\User;
use App\Services\User\IUserService;

class UserController extends Controller
{
    public function __construct(private readonly IUserService $userService)
    {
    }

    public function index(): ResponseData
    {
        $users = $this->userService->getRepo()->getPaginateList();

        return $this->httpOk(new UserCollection($users));
    }

    public function store(UpsertUserRequest $request): ResponseData
    {
        $data = $request->validated();

        $user = $this->userService->getRepo()->create($data);

        return $this->httpCreated(new UserItemResource($user));
    }

    public function show(User $user): ResponseData
    {
        return $this->httpOk(new UserItemResource($user));
    }

    public function update(UpsertUserRequest $request, User $user): ResponseData
    {
        $data = $request->validated();

        $user = $this->userService->getRepo()->update($data, $user->id);

        return $this->httpOk(new UserItemResource($user));
    }

    public function destroy(string $id): ResponseData
    {
        $this->userService->getRepo()->delete($id);

        return $this->httpNoContent();
    }
}
