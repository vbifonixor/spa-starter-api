<?php

namespace Tests\Controllers\Authors;

use App\Book;
use App\Author;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FetchTest extends TestCase
{
    use WithoutMiddleware, DatabaseMigrations;

    public function testCanFetchAuthors()
    {
        $author = factory(Author::class)->create();

        $this->json('GET', '/api/authors');

        $this->assertResponseOk()
            ->seeJson([
                'name' => $author->name,
            ])->seeJsonStructure([
                'data' => [
                    '*' => ['id', 'name'],
                ],
            ]);
    }

    public function testCanFetchAuthorsAlongWithTheirBooks()
    {
        $book = factory(Book::class)->create();

        $this->json('GET', '/api/authors?include=books');

        $this->assertResponseOk()
            ->seeJson([
                'title' => $book->title,
                'name' => $book->author->name,
            ])->seeJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'name',
                        'books' => [
                            '*' => ['id', 'title'],
                        ],
                    ],
                ],
            ]);
    }
}
