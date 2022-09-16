<?php

namespace App\Actions;

use App\Models\User\User;

class GenerateEnrollment
{
    public function run(): string
    {
        $now = now()->format('dmY');

        $randomCode = rand(1000, 9999);

        $enrollment = $randomCode . $now;

        if(User::query()->where('enrollment', $enrollment)->first()){
            $enrollment = $this->run();
        }

        return $enrollment;
    }
}
