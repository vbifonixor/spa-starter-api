<?php

use App\Author;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthorsControllerTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    public function testCanListTheAuthors()
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

    public function testCanCreateAuthor()
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

    public function testCanShowAuthor()
    {
        $author = factory(Author::class)->create();

        $this->json('GET', '/api/authors/1');

        $this->assertResponseOk();
        $this->seeJson(['name' => $author->name]);
        $this->seeJsonStructure([
            'data' => ['id', 'name'],
        ]);
    }

    public function testCanUpdateAuthor()
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

    public function testCanDeleteAuthor()
    {
        factory(Author::class)->create();

        $this->json('DELETE', '/api/authors/1');

        $this->dontSeeInDatabase('authors', ['id' => 1]);
        $this->assertResponseStatus(204);
    }

    /**
     * @dataProvider urlProvider
     */
    public function testCanGet404($method, $url, $fields = [])
    {
        $this->json($method, $url, $fields);

        $this->assertResponseStatus(404);
        $this->seeJsonStructure([
            'errors' => [[]],
        ]);
    }

    public function testIsValidatingFieldsBeforeCreate()
    {
        $this->json('POST', '/api/authors');

        $this->assertResponseStatus(422);
        $this->seeJsonStructure([
            'errors' => [[]],
        ]);
    }

    public function testIsValidatingFieldsBeforeUpdate()
    {
        factory(Author::class)->create();

        $this->json('PUT', '/api/authors/1');

        $this->assertResponseStatus(422);
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
            ['PUT', '/api/authors/1', ['name' => 'John']],
            ['DELETE', '/api/authors/1'],
        ];
    }
}
