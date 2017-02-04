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

    /** @test */
    public function can_delete_an_author()
    {
        factory(Author::class)->create();

        $this->json('DELETE', '/api/authors/1');

        $this->dontSeeInDatabase('authors', ['id' => 1]);
        $this->assertResponseStatus(204);
    }

    /**
     * @test
     * @dataProvider urlProvider
     */
    public function get_404_if_author_is_not_found($method, $url)
    {
        $this->json($method, $url);

        $this->assertResponseStatus(404);
        $this->seeJsonStructure([
            'errors' => [[]],
        ]);
    }

    /**
     * Provider an array of URL arguments.
     *
     * @return array
     */
    public function urlProvider()
    {
        return [
            ['GET', '/api/authors/1'],
            ['PUT', '/api/authors/1'],
            ['DELETE', '/api/authors/1'],
        ];
    }
}
