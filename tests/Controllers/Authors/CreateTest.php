<?php

namespace Tests\Controllers\Authors;

use Tests\TestCase;
use Tests\Helpers\WithoutMiddleware;
use Laravel\Lumen\Testing\DatabaseMigrations;

class CreateTest extends TestCase
{
    use WithoutMiddleware, DatabaseMigrations;

    public function testIsValidatingFields()
    {
        $user = factory(\App\User::class)->create();

        $this->actingAs($user)
            ->json('POST', '/api/authors');

        dd($this->response);

        $this->assertResponseStatus(422);
    }

    public function testCanCreateAuthor()
    {
        $this->json('POST', '/api/authors', [
            'name' => 'Daniel Wallace',
        ]);

        $this->assertResponseStatus(201)
            ->seeInDatabase('authors', [
                'name' => 'Daniel Wallace',
            ])->seeJson([
                'name' => 'Daniel Wallace',
            ])->seeJsonStructure([
                'data' => ['id', 'name'],
            ]);
    }
}
