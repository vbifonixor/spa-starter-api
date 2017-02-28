<?php

namespace Tests\Controllers\Books;

use App\Author;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

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

        $this->assertResponseStatus(201)
            ->seeInDatabase('books', [
                'title' => $title,
                'author_id' => $author->id,
            ])->seeJson([
                'title' => $title,
                'name' => $author->name,
            ])->seeJsonStructure([
                'data' => [
                    'id', 'title',
                    'author' => ['id', 'name'],
                ],
            ]);
    }

    /**
     * @dataProvider invalidFieldsValuesProvider
     */
    public function testIsValidatingFields($title, $author)
    {
        $this->json('POST', '/api/books', compact('title', 'author'));

        $this->assertResponseStatus(422)
            ->seeJsonStructure([
                'errors' => [[]],
            ]);
    }
}
