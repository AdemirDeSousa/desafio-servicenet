<?php

namespace App\Repositories;

use App\Facades\Actions\GenerateEnrollment;
use App\Models\User\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

}
