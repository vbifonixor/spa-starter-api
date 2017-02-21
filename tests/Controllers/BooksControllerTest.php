<?php

use App\Author;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BooksControllerTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    public function testCanCreateBook()
    {
        $title = 'The Jedi Path';
        $author = Author::create([
            'name' => 'Daniel Wallace'
        ]);

        $this->json('POST', '/api/books', [
            'title' => $title,
            'author' => $author->id,
        ]);

        $this->assertResponseStatus(201);

        $this->seeInDatabase('books', [
            'title' => $title,
            'author_id' => $author->id,
        ]);

        $this->seeJson([
            'title' => $title,
            'name' => $author->name,
        ]);

        $this->seeJsonStructure([
            'data' => [
                'id', 'title',
                'author' => ['id', 'name'],
            ],
        ]);
    }
}
