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

    /** @test */
    public function can_create_an_author()
    {
        $this->json('POST', '/api/authors', [
            'name' => 'John Doe',
        ]);

        $this->seeInDatabase('authors', ['name' => 'John Doe']);
        $this->assertResponseStatus(201);
        $this->seeJson([
            'name' => 'John Doe',
        ]);
        $this->seeJsonStructure([
            'data' => ['id', 'name'],
        ]);
    }

    /** @test */
    public function can_show_an_author()
    {
        $author = factory(Author::class)->create();

        $this->json('GET', '/api/authors/1');

        $this->assertResponseOk();
        $this->seeJson(['name' => $author->name]);
        $this->seeJsonStructure([
            'data' => ['id', 'name'],
        ]);
    }

    /** @test */
    public function can_update_an_author()
    {
        $author = factory(Author::class)->create();

        $this->json('PUT', '/api/authors/1', [
            'name' => 'John Doe',
        ]);

        $this->seeInDatabase('authors', [
            'id' => $author->id,
            'name' => 'John Doe',
        ]);

        $this->assertResponseOk();
        $this->seeJson([
            'id' => $author->id,
            'name' => 'John Doe',
        ]);
        $this->seeJsonStructure([
            'data' => ['id', 'name'],
        ]);
    }
}
