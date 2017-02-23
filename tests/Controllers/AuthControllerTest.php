<?php

namespace Tests\Controllers;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testInvalidCredentials()
    {
        $this->json('POST', '/api/auth/token');

        $this->assertResponseStatus(401);
        $this->seeJsonStructure([
            'errors' => [[]],
        ]);
    }

    public function testCanGetAuthenticatedToken()
    {
        $user = factory(User::class)->create();

        $this->json('POST', '/api/auth/token', [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $this->assertResponseOk();
        $this->seeJsonStructure([
            'data' => ['token'],
        ]);
    }
}
