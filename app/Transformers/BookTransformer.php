<?php

namespace App\Transformers;

use App\Book;
use League\Fractal\TransformerAbstract;

class BookTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include.
     *
     * @var array
     */
    protected $availableIncludes = [
        'author',
    ];

    /**
     * Transform book model into an array.
     *
     * @param  Book   $book
     *
     * @return array
     */
    public function transform(Book $book)
    {
        return [
            'id' => $book->id,
            'title' => $book->title,
        ];
    }

    /**
     * Include book author.
     *
     * @param  Book   $book
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeAuthor(Book $book)
    {
        return $this->item($book->author, new AuthorTransformer);
    }
}
