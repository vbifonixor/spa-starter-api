<?php

namespace Tests\Books;

use App\Book;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

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
                'data' => ['*' => [
                    'id', 'title',
                ]],
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
                'data' => ['*' => [
                    'id', 'title', 'author' => [
                        'id', 'name',
                    ],
                ]],
            ]);
    }

    public function testCanPaginateResults()
    {
        factory(Book::class, 2)->create();

        $response = $this->json('GET', '/api/books?limit=1')->parseJsonBody();

        $this->assertEquals(1, count($response['data']));
        $this->seeJson([
                'total' => 2,
                'per_page' => 1,
                'last_page' => 2,
            ])->seeJsonStructure([
                'data' => [
                    '*' => ['id', 'title'],
                ],
                'metadata' => [
                    'pagination' => [
                        'total', 'per_page', 'current_page',
                        'last_page', 'next_page_url', 'prev_page_url', 'from', 'to',
                    ],
                ],
            ]);
    }

    public function testCanChangeOrderOfBooks()
    {
        factory(Book::class, 2)->create();

        $response = $this->json('GET', '/api/books?sort=id&order_by=asc')->parseJsonBody();

        $this->assertEquals(1, $response['data'][0]['id']);
        $this->assertEquals(2, $response['data'][1]['id']);

        $response = $this->json('GET', '/api/books?sort=id&order_by=desc')->parseJsonBody();

        $this->assertEquals(2, $response['data'][0]['id']);
        $this->assertEquals(1, $response['data'][1]['id']);
    }
}
