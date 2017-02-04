<?php

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function is_checking_for_invalid_credentials()
    {
        $this->json('POST', '/api/auth/token');

        $this->assertResponseStatus(401);
        $this->seeJsonStructure([
            'errors' => [[]],
        ]);
    }

    /** @test */
    public function can_get_authenticated_token()
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
