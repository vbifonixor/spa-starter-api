<?php

namespace Tests\Books;

use App\Book;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ShowTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    public function testCanFetchBook()
    {
        $book = factory(Book::class)->create();

        $this->json('GET', '/api/books/1');

        $this->assertResponseOk()
            ->seeJson([
                'id' => $book->id,
                'title' => $book->title,
            ])->seeJsonStructure([
                'data' => ['id', 'title'],
            ]);
    }

    public function testCanFetchBookAlongWithAuthor()
    {
        $book = factory(Book::class)->create();

        $this->json('GET', '/api/books/1?include=author');

        $this->assertResponseOk()
            ->seeJson([
                'id' => $book->author->id,
                'name' => $book->author->name,
            ])->seeJsonStructure([
                'data' => [
                    'id', 'title',
                    'author' => ['id', 'name'],
                ],
            ]);
    }

    public function testGet404IfNoBookIsFound()
    {
        $this->json('GET', '/api/books/1');

        $this->assertResponseStatus(404)
            ->seeJsonStructure([
                'errors' => [[]],
            ]);
    }
}
