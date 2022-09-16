<?php

namespace Tests\Feature\Users;

use App\Models\User\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ShowUserTest extends TestCase
{

    /** @test */
    public function should_return_a_user_successfully()
    {
        $user = User::factory()->create();

        $this->getJson(route('api.users.show', ['id' => $user->id]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'birthdate' => $user->birthdate,
                    'enrollment' => $user->enrollment,
                ]
            ]);
    }

}
