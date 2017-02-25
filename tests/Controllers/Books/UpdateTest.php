<?php

namespace Tests\Controllers\Books;

use App\Book;
use App\Author;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

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

        $this->assertResponseOk()
            ->seeInDatabase('books', [
                'id' => 1,
                'title' => 'The Jedi Path',
                'author_id' => $author->id,
            ])->seeJson([
                'title' => 'The Jedi Path',
                'name' => $author->name,
            ])->seeJsonStructure([
                'data' => [
                    'id', 'title',
                    'author' => ['id', 'name'],
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

        $this->assertResponseStatus(404)
            ->seeJsonStructure([
                'errors' => [[]],
            ]);
    }

    /**
     * @dataProvider invalidFieldsValuesProvider
     */
    public function testIsValidatingFields($title, $author)
    {
        $this->json('PUT', '/api/books/1', compact('title', 'author'));

        $this->assertResponseStatus(422)
            ->seeJsonStructure([
                'errors' => [[]],
            ]);
    }
}
