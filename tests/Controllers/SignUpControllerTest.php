<?php

namespace Tests\Controllers;

use App\User;
use Tests\TestCase;
use Laravel\Lumen\Testing\DatabaseMigrations;

class SignUpControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIsCheckingForEmptyFields()
    {
        $this->json('POST', '/api/signup');

        $this->assertResponseStatus(422);
        $this->seeJsonStructure([
            'errors' => ['name', 'email', 'password'],
        ]);
    }

    public function testIsCheckingForValidEmailAddress()
    {
        $this->json('POST', '/api/signup', [
            'name' => 'John',
            'email' => 'foo',
            'password' => 'bar',
        ]);

        $this->assertResponseStatus(422);
    }

    public function testIsCheckingForUniqueEmailAddress()
    {
        $email = factory(User::class)->create()->email;

        $this->json('POST', '/api/signup', [
            'name' => 'John',
            'email' => $email,
            'password' => 'bar',
        ]);

        $this->assertResponseStatus(422);
    }

    public function testSignUp()
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
            'data' => [
                'token',
                'user' => ['id', 'name', 'email'],
            ],
        ]);
    }
}
