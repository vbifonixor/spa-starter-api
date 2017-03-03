<?php

namespace Tests\Controllers;

use App\User;
use Tests\TestCase;
use Laravel\Lumen\Testing\DatabaseMigrations;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testInvalidCredentials()
    {
        $this->json('POST', '/api/auth/token');

        $this->assertResponseStatus(401);
    }

    public function testCanGetAuthenticatedToken()
    {
        $user = factory(User::class)->create();

        $this->json('POST', '/api/auth/token', [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $this->assertResponseOk();
        $this->seeJson([
            'name' => $user->name,
            'email' => $user->email,
        ]);
        $this->seeJsonStructure([
            'data' => [
                'token',
                'user' => ['id', 'name', 'email'],
            ],
        ]);
    }
}
