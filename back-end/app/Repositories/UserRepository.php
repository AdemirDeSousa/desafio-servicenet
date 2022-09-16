<?php

namespace App\Repositories;

use App\Facades\Actions\GenerateEnrollment;
use App\Models\User\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserRepository implements UserRepositoryInterface
{
    private User $users;

    public function __construct(User $users)
    {
        $this->users = $users;
    }

    public function getAll(Request $request): Collection
    {
        $result = $this->users->query();

        if($request->filled('name')){
            $result = $result->where('name', 'LIKE','%' . $request->name . '%');
        }

        return $result->orderBy('name')->get();
    }

    public function store(array $data): User
    {
        return $this->users->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'birthdate' => $data['birthdate'],
            'enrollment' => GenerateEnrollment::run(),
            'password' => Hash::make($data['password'])
        ]);
    }

    public function findOrFail(string $id): User
    {
        $result = $this->users->find($id);

        if(!$result){
            throw new NotFoundHttpException('Usuario nao encontrado');
        }

        return $result;
    }

    public function delete(string $id): void
    {
        $user = $this->findOrFail($id);

        $user->delete();
    }


}
