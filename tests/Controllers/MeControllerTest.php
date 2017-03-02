<?php

namespace Tests\Controllers;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Testing\DatabaseMigrations;

class MeControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIsValidatingTokenBeforeShowUser()
    {
        $this->json('GET', '/api/me');

        $this->assertResponseStatus(400);
        $this->seeJsonStructure([
            'errors' => [[]],
        ]);
    }

    public function testCanFetchAuthenticatedUser()
    {
        $user = factory(User::class)->create();

        $token = Auth::login($user);

        $this->json('GET', '/api/me', [
            'token' => $token,
        ]);

        $this->assertResponseOk();
        $this->seeJson([
            'name' => $user->name,
            'email' => $user->email,
        ]);
        $this->seeJsonStructure([
            'data' => [
                'id', 'name', 'email',
            ],
        ]);
    }
}
