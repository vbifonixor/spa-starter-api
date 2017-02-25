<?php

namespace Tests\Controllers\Authors;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateTest extends TestCase
{
    use WithoutMiddleware, DatabaseMigrations;

    public function testIsValidatingFields()
    {
        $this->json('POST', '/api/authors');

        $this->assertResponseStatus(422)
            ->seeJsonStructure([
                'errors' => [[]],
            ]);
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
