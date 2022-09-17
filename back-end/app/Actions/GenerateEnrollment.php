<?php

namespace App\Actions;

use App\Models\User\User;

class GenerateEnrollment
{
    public function run(): string
    {
        do {

            $now = now()->format('dmY');

            $randomCode = rand(1000, 9999);

            $enrollment = $randomCode . $now;

        } while (User::query()->where('enrollment', $enrollment)->first());

        return $enrollment;
    }
}
