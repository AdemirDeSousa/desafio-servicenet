<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        return $this->userService->getUsers($request);
    }

    public function store(StoreUserRequest $request)
    {
        return $this->userService->storeUser($request->all());
    }

    public function show(string $id)
    {
        return $this->userService->findUser($id);
    }

}
