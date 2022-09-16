<?php

namespace Tests\Feature\Users;

use App\Models\User\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DestroyUserTest extends TestCase
{
    /** @test */
    public function it_can_delete_a_user()
    {
        $user = User::factory()->create();

        $this->deleteJson(route('api.users.destroy', $user->id))
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }

}
