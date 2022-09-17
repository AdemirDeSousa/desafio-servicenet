<?php

namespace App\Repositories\Contracts;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function getAll(Request $request): Collection;

    public function store(array $data): User;

    public function findOrFail(string $id): User;

    public function update(array $data, string $id): void;

    public function updatePassword(string $newPassword, string $id): void;

    public function delete(string $id): void;
}
