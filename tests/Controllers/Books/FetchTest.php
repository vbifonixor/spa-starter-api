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

        $this->assertResponseOk()
            ->seeJson([
                'title' => $book->title,
            ])->seeJsonStructure([
                'data' => [
                    '*' => ['id', 'title'],
                ],
                'metadata' => [
                    'pagination',
                ],
            ]);
    }

    public function testCanFetchBooksAlongWithAuthor()
    {
        $book = factory(Book::class)->create();

        $this->json('GET', '/api/books?include=author');

        $this->assertResponseOk()
            ->seeJson([
                'name' => $book->author->name,
            ])->seeJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'title',
                        'author' => [
                            'id', 'name',
                        ],
                    ],
                ],
                'metadata' => [
                    'pagination',
                ],
            ]);
    }
}
