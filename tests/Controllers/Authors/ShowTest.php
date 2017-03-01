<?php

namespace Tests\Controllers\Authors;

use App\Book;
use App\Author;
use Tests\TestCase;
use Tests\Helpers\WithoutMiddleware;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ShowTest extends TestCase
{
    use WithoutMiddleware, DatabaseMigrations;

    public function testGet404IfNoAuthorIsFound()
    {
        $this->json('GET', '/api/authors/1');

        $this->assertResponseStatus(404);
        $this->seeJsonStructure([
            'errors' => [[]],
        ]);
    }

    public function testCanFetchAuthor()
    {
        factory(Author::class)->create([
            'name' => 'Daniel Wallace',
        ]);

        $this->json('GET', '/api/authors/1');

        $this->assertResponseOk();
        $this->seeJson([
            'name' => 'Daniel Wallace',
        ]);
        $this->seeJsonStructure([
            'data' => ['id', 'name'],
        ]);
    }

    public function testCanFetchAuthorAlongWithBooks()
    {
        $author = factory(Author::class)->create([
            'name' => 'Daniel Wallace',
        ]);

        $book = factory(Book::class)->create([
            'title' => 'The Jedi Path',
            'author_id' => $author->id,
        ]);

        $this->json('GET', '/api/authors/1?include=books');

        $this->assertResponseOk();
        $this->seeJson([
            'title' => 'The Jedi Path',
            'name' => 'Daniel Wallace',
        ]);
        $this->seeJsonStructure([
            'data' => [
                'id', 'name',
                'books' => [
                    '*' => ['id', 'title'],
                ],
            ],
        ]);
    }
}
