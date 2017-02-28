<?php

use App\Book;
use App\Author;
use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authors = Author::all();

        factory(Book::class, 50)->make([
            'author_id' => null,
        ])->each(function (Book $book) use ($authors) {
            $book->author()
                ->associate($authors->random())
                ->save();
        });
    }
}
