<?php

namespace App\Services\User;

use App\Http\Resources\User\UsersResource;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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


    public function storeUser(array $data): JsonResponse
    {
        try {

            $this->userRepository->store($data);

            return response()->json([
                'message' => 'Usuario criado com sucesso'
            ], 201);

        } catch (\Exception $e) {

            Log::info('Falha ao cadastrar usuario', [$e->getMessage()]);

            return response()->json([
                'message' => 'Falha ao cadastrar usuario'
            ], 500);

        }
    }

}
