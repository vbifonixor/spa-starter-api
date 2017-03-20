<?php

namespace App\Transformers;

use App\Author;
use League\Fractal\TransformerAbstract;

class AuthorTransformer extends TransformerAbstract
{
    /**
     * Includeable resources.
     *
     * @var array
     */
    protected $availableIncludes = [
        'books',
    ];

    /**
     * Transform author model into an array.
     *
     * @param  Author $author
     *
     * @return array
     */
    public function transform(Author $author)
    {
        return [
            'id' => $author->id,
            'name' => $author->name,
        ];
    }

    /**
     * Include author's books.
     *
     * @param  Author $author
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeBooks(Author $author)
    {
        return $this->collection($author->books, new BookTransformer);
    }
}
