<?php

namespace App\Repositories\Contracts;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function getAll(Request $request): Collection;
}
