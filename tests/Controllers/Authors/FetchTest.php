<?php

namespace Tests\Controllers\Authors;

use App\Book;
use App\Author;
use Tests\TestCase;
use Tests\Helpers\WithoutMiddleware;
use Laravel\Lumen\Testing\DatabaseMigrations;

class FetchTest extends TestCase
{
    use WithoutMiddleware, DatabaseMigrations;

    public function testCanFetchAuthors()
    {
        $author = factory(Author::class)->create();

        $this->json('GET', '/api/authors');

        $this->assertResponseOk();
        $this->seeJson([
            'name' => $author->name,
        ]);
        $this->seeJsonStructure([
            'data' => [
                '*' => ['id', 'name'],
            ],
            'meta' => [
                'pagination',
            ],
        ]);
    }

    public function testCanFetchAuthorsAlongWithTheirBooks()
    {
        $book = factory(Book::class)->create();

        $this->json('GET', '/api/authors?include=books');

        $this->assertResponseOk();
        $this->seeJson([
            'title' => $book->title,
            'name' => $book->author->name,
        ]);
        $this->seeJsonStructure([
            'data' => [
                '*' => [
                    'id', 'name',
                    'books' => [
                        '*' => ['id', 'title'],
                    ],
                ],
            ],
            'meta' => [
                'pagination',
            ],
        ]);
    }
}
