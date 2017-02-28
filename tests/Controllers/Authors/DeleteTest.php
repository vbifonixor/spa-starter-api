<?php

namespace Tests\Controllers\Authors;

use App\Author;
use Tests\TestCase;
use Tests\Helpers\WithoutMiddleware;
use Laravel\Lumen\Testing\DatabaseMigrations;

class DeleteTest extends TestCase
{
    use WithoutMiddleware, DatabaseMigrations;

    public function testGet404IfNoAuthorIsFound()
    {
        $this->json('DELETE', '/api/authors/1');

        $this->assertResponseStatus(404)
            ->seeJsonStructure([
                'errors' => [[]],
            ]);
    }

    public function testCanDeleteAuthor()
    {
        factory(Author::class)->create();

        $this->json('DELETE', '/api/authors/1');

        $this->assertResponseStatus(204)
            ->dontSeeInDatabase('authors', [
                'id' => 1,
            ]);
    }
}
