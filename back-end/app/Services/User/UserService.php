<?php

namespace App\Services\User;

use App\Http\Resources\User\UsersResource;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function findUser(string $id)
    {
        try {

            return new UsersResource($this->userRepository->findOrFail($id));

        } catch (NotFoundHttpException $e) {

            return response()->json([
                'message' => 'Usuario nao encontrado'
            ], 404);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Falha ao buscar usuario'
            ], 500);
        }
    }

    public function updateUser(array $data, string $id)
    {
        try {

            $this->userRepository->update($data, $id);

            if(array_key_exists('password', $data)){
                $this->userRepository->updatePassword($data['password'], $id);
            }

            return response()->json([
                'message' => 'Usuario atualizado com sucesso'
            ], 200);

        } catch (NotFoundHttpException $e) {

            return response()->json([
                'message' => 'Usuario nao encontrado'
            ], 404);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Falha ao atualizar usuario'
            ], 500);
        }
    }

    public function deleteUser(string $id)
    {
        try {

            $this->userRepository->delete($id);

            return response()->json([
                'message' => 'Usuario excluido com sucesso'
            ], 200);

        } catch (NotFoundHttpException $e) {

            return response()->json([
                'message' => 'Usuario nao encontrado'
            ], 404);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Falha ao excluir usuario'
            ], 500);
        }
    }

}
