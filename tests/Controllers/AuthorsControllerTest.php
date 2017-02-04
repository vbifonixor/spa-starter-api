<?php

use App\Author;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthorsControllerTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    /** @test */
    public function can_list_the_authors()
    {
        $authors = factory(Author::class, 5)->create();

        $this->json('GET', '/api/authors');

        $this->assertResponseOk(200);
        $this->seeJsonStructure([
            'data' => [
                '*' => ['id', 'name'],
            ],
        ]);
    }
}
