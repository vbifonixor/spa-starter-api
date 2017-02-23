<?php

namespace Tests\Books;

use App\Book;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    public function testCanDeleteBook()
    {
        factory(Book::class)->create();

        $this->json('DELETE', '/api/books/1');

        $this->assertResponseStatus(204)
            ->dontSeeInDatabase('books', ['id' => 1]);
    }

    public function testGet404IfNoBookIsFound()
    {
        $this->json('DELETE', '/api/books/1');

        $this->assertResponseStatus(404)
            ->seeJsonStructure([
                'errors' => [[]],
            ]);
    }
}
