<?php

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SignUpControllerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function is_checking_for_empty_fields()
    {
        $this->json('POST', '/api/signup');

        $this->assertResponseStatus(422);
        $this->seeJsonStructure([
            'errors' => [[]],
        ]);
    }

    /** @test */
    public function is_checking_for_invalid_email()
    {
        $this->json('POST', '/api/signup', [
            'name' => 'John',
            'email' => 'foo',
            'password' => 'bar'
        ]);

        $this->assertResponseStatus(422);
        $this->seeJsonStructure([
            'errors' => [[]],
        ]);
    }

    /** @test */
    public function is_checking_for_unique_email()
    {
        $email = factory(User::class)->create()->email;

        $this->json('POST', '/api/signup', [
            'name' => 'John',
            'email' => $email,
            'password' => 'bar'
        ]);

        $this->assertResponseStatus(422);
        $this->seeJsonStructure([
            'errors' => [[]],
        ]);
    }

    /** @test */
    public function can_signup_user()
    {
        $user = factory(User::class)->make([
            'password' => str_random(5),
        ]);

        $this->json('POST', '/api/signup', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
        ]);

        $this->seeInDatabase('users', $user->toArray());
        $this->assertResponseStatus(201);
        $this->seeJson($user->toArray());
        $this->seeJsonStructure([
            'data' => ['id', 'name', 'email'],
            'metadata' => ['token'],
        ]);
    }
}
