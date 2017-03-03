<?php

namespace Tests\Controllers\Books;

use App\Author;
use Tests\Helpers\WithoutMiddleware;
use Laravel\Lumen\Testing\DatabaseMigrations;

class CreateTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    public function testCanCreateBook()
    {
        $title = 'The Jedi Path';
        $author = Author::create([
            'name' => 'Daniel Wallace',
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

    /**
     * @dataProvider invalidFieldsValuesProvider
     */
    public function testIsValidatingFields($title, $author, $expectedErrors)
    {
        $this->json('POST', '/api/books', compact('title', 'author'));

        $this->assertResponseStatus(422);
        $this->seeJsonStructure([
            'errors' => $expectedErrors,
        ]);
    }
}
