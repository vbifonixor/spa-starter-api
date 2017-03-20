<?php

namespace Tests\Controllers\Books;

use App\Book;
use App\Author;
use Tests\Helpers\WithoutMiddleware;
use Laravel\Lumen\Testing\DatabaseMigrations;

class UpdateTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    public function testCanUpdateBook()
    {
        $book = factory(Book::class)->create();
        $author = factory(Author::class)->create();

        $this->json('PUT', '/api/books/1', [
            'title' => 'The Jedi Path',
            'author' => $author->id,
        ]);

        $this->assertResponseOk();
        $this->seeInDatabase('books', [
            'id' => 1,
            'title' => 'The Jedi Path',
            'author_id' => $author->id,
        ]);
        $this->seeJson([
            'title' => 'The Jedi Path',
        ]);
        $this->seeJsonStructure([
            'data' => [
                'id', 'title',
            ],
        ]);
    }

    public function testGet404IfNoBookIsFound()
    {
        $author = factory(Author::class)->create();

        $this->json('PUT', '/api/books/1', [
            'title' => 'The Jedi Path',
            'author' => $author->id,
        ]);

        $this->assertResponseStatus(404);
        $this->seeJsonStructure([
            'errors' => [[]],
        ]);
    }

    /**
     * @dataProvider invalidFieldsValuesProvider
     */
    public function testIsValidatingFields($title, $author, $expectedErrors)
    {
        $this->json('PUT', '/api/books/1', compact('title', 'author'));

        $this->assertResponseStatus(422);
        $this->seeJsonStructure([
            'errors' => $expectedErrors,
        ]);
    }
}
