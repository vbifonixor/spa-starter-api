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

        $this->assertResponseStatus(422);
        $this->seeJsonStructure([
            'errors' => ['name'],
        ]);
    }

    public function testCanCreateAuthor()
    {
        $this->json('POST', '/api/authors', [
            'name' => 'Daniel Wallace',
        ]);

        $this->assertResponseStatus(201);

        $this->seeInDatabase('authors', [
            'name' => 'Daniel Wallace',
        ]);

        $this->seeJson([
            'name' => 'Daniel Wallace',
        ]);

        $this->seeJsonStructure([
            'data' => ['id', 'name'],
        ]);
    }
}
