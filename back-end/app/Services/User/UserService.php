<?php

namespace App\Services\User;

use App\Http\Resources\User\UsersResource;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsers(Request $request)
    {
        return UsersResource::collection($this->userRepository->getAll($request));
    }

}
