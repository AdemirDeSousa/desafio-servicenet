<?php

namespace Tests\Feature\Users;

use App\Models\User\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IndexUserTest extends TestCase
{
    /** @test */
    public function it_should_return_a_users_list_successfully()
    {
        User::factory()->count(10)->create();

        $this->getJson(route('api.users.index'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'name',
                        'email',
                        'birthdate',
                        'enrollment'
                    ]
                ]
            ]);

    }

    /** @test */
    public function it_should_return_a_empty_data_successfully()
    {
        $this->getJson(route('api.users.index'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => []
            ]);
    }

}
