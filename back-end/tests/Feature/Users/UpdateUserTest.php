<?php

namespace Tests\Feature\Users;

use App\Models\User\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    public const ENCODED_PASSWORD = '$2a$12$IqirdFrTM0w4pF5.yhQKbOpYe2fy.GmzmxHEVb3iVZez5QQPSSjPy';

    /** @test */
    public function it_should_update_a_opportunity_successfully()
    {
        $user = User::factory()->create();

        Hash::shouldReceive('make')->once()
            ->andReturn(self::ENCODED_PASSWORD);

        $payload = [
            'name' => 'Kleiton Editado',
            'email' => 'new.email@gmail.com',
            'birthdate' => '2000-12-12',
            'password' => 'password'
        ];

        $this->putJson(route('api.users.update', ['id' => $user->id]), $payload)
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'Usuario atualizado com sucesso'
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Kleiton Editado',
            'email' => 'new.email@gmail.com',
            'birthdate' => '2000-12-12',
            'password' => self::ENCODED_PASSWORD
        ]);
    }

    /** @test */
    public function fields_must_be_present()
    {
        $user = User::factory()->create();

        $this->putJson(route('api.users.update', ['id' => $user->id]), [])
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                'data' => [
                    'name' => [
                        __('validation.required', ['attribute' => 'name'])
                    ],
                    'birthdate' => [
                        __('validation.required', ['attribute' => 'birthdate'])
                    ],
                    'email' => [
                        __('validation.required', ['attribute' => 'email'])
                    ]
                ]]);
    }

    /** @test */
    public function field_email_must_be_unique()
    {
        User::factory()->create(['email' => 'teste@gmail.com']);
        $user2 = User::factory()->create(['email' => 'teste2@gmail.com']);


        $payload = [
            'name' => 'Kleiton Editado',
            'email' => 'teste@gmail.com',
            'birthdate' => '2000-12-12',
            'password' => 'password'
        ];

        $this->putJson(route('api.users.update', ['id' => $user2->id]), $payload)
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                'data' => [
                    'email' => [
                        __('validation.unique', ['attribute' => 'email'])
                    ]
                ]
            ]);
    }
}
