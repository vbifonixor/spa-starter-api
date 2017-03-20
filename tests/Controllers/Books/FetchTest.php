<?php

namespace Tests\Controllers\Books;

use App\Book;
use Tests\Helpers\WithoutMiddleware;
use Laravel\Lumen\Testing\DatabaseMigrations;

class FetchTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    public function testCanFetchBooks()
    {
        $book = factory(Book::class)->create();

        $this->json('GET', '/api/books');

        $this->assertResponseOk();
        $this->seeJson([
            'title' => $book->title,
        ]);
        $this->seeJsonStructure([
            'data' => [
                '*' => ['id', 'title'],
            ],
            'meta' => [
                'pagination',
            ],
        ]);
    }

    public function testCanFetchBooksAlongWithAuthor()
    {
        $book = factory(Book::class)->create();

        $this->json('GET', '/api/books?include=author');

        $this->assertResponseOk();
        $this->seeJson([
            'name' => $book->author->name,
        ]);
        $this->seeJsonStructure([
            'data' => [
                '*' => [
                    'id', 'title',
                    'author' => [
                        'data' => ['id', 'name'],
                    ],
                ],
            ],
            'meta' => [
                'pagination',
            ],
        ]);
    }
}
