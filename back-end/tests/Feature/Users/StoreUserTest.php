<?php

namespace Tests\Feature\Client;

use App\Facades\Actions\GenerateEnrollment;
use App\Models\User\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class StoreClientTest extends TestCase
{
    public const ENCODED_PASSWORD = '$2a$12$IqirdFrTM0w4pF5.yhQKbOpYe2fy.GmzmxHEVb3iVZez5QQPSSjPy';

    /** @test */
    public function should_create_a_user_successfully()
    {
        GenerateEnrollment::shouldReceive('run')->once()
            ->andReturn('904415092022');

        Hash::shouldReceive('make')->once()
            ->andReturn(self::ENCODED_PASSWORD);

        $data = [
            'name' => 'Kleiton',
            'email' => 'kleiton@gmail.com',
            'birthdate' => '1999-05-28',
            'password' => 'password'
        ];

        $this->postJson(route('api.users.store'), $data)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'message' => 'Usuario criado com sucesso'
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Kleiton',
            'email' => 'kleiton@gmail.com',
            'birthdate' => '1999-05-28',
            'enrollment' => '904415092022',
            'password' => self::ENCODED_PASSWORD
        ]);
    }

    /** @test */
    public function fields_must_be_present()
    {
        $this->postJson(route('api.users.store'), [])
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
                    ],
                    'password' => [
                        __('validation.required', ['attribute' => 'password'])
                    ]
                ]]);
    }

    /** @test */
    public function field_email_must_be_a_valid_email()
    {
        $this->postJson(route('api.users.store'), [
            'email' => 'invalid-email'
        ])->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                'data' => [
                    'email' => [
                        __('validation.email', ['attribute' => 'email'])
                    ]
                ]
            ]);
    }

    /** @test */
    public function field_email_must_be_unique()
    {
        User::factory()->create(['email' => 'teste@gmail.com']);

        $data = ['email' => 'teste@gmail.com'];

        $this->postJson(route('api.users.store'), $data)->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                'data' => [
                    'email' => [
                        __('validation.unique', ['attribute' => 'email'])
                    ]
                ]
            ]);
    }

}
