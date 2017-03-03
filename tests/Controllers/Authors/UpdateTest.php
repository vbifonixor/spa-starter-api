<?php

namespace Tests\Controllers\Authors;

use App\Author;
use Tests\TestCase;
use Tests\Helpers\WithoutMiddleware;
use Laravel\Lumen\Testing\DatabaseMigrations;

class UpdateTest extends TestCase
{
    use WithoutMiddleware, DatabaseMigrations;

    public function testGet404IfNoAuthorIsFound()
    {
        $this->json('PUT', '/api/authors/1', [
            'name' => 'Daniel Wallace',
        ]);

        $this->assertResponseStatus(404);
        $this->seeJsonStructure([
            'errors' => [[]],
        ]);
    }

    public function testIsValidatingFields()
    {
        $this->json('PUT', '/api/authors/1');

        $this->assertResponseStatus(422);
        $this->seeJsonStructure([
            'errors' => ['name'],
        ]);
    }

    public function testCanUpdateAuthor()
    {
        factory(Author::class)->create();

        $this->json('PUT', '/api/authors/1', [
            'name' => 'Daniel Wallace',
        ]);

        $this->assertResponseOk();
        $this->seeInDatabase('authors', [
            'id' => 1,
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
