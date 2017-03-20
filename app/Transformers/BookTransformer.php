<?php

namespace App\Transformers;

use App\Book;
use League\Fractal\TransformerAbstract;

class BookTransformer extends TransformerAbstract
{
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
}
