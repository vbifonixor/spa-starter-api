<?php

namespace Tests\Controllers\Books;

use App\Book;
use Tests\Helpers\WithoutMiddleware;
use Laravel\Lumen\Testing\DatabaseMigrations;

class DeleteTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    public function testCanDeleteBook()
    {
        factory(Book::class)->create();

        $this->json('DELETE', '/api/books/1');

        $this->assertResponseStatus(204);
        $this->dontSeeInDatabase('books', ['id' => 1]);
    }

    public function testGet404IfNoBookIsFound()
    {
        $this->json('DELETE', '/api/books/1');

        $this->assertResponseStatus(404);
        $this->seeJsonStructure([
            'errors' => [[]],
        ]);
    }
}
