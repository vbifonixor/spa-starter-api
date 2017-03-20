<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use App\Transformers\BookTransformer;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $limit = $this->parameters->limit(10);
        $sort = $this->parameters->sortBy('id');
        $order = $this->parameters->orderBy('desc');

        $books = Book::orderBy($sort, $order)->paginate($limit);

        return $this->response->withPagination($books, new BookTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'author' => 'required|exists:authors,id',
        ]);

        $book = new Book($request->all());

        $book->author()
            ->associate($request->author)
            ->save();

        return $this->response->withCreated($book, new BookTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $book = Book::find($id);

        if (! $book) {
            return $this->response->withNotFound();
        }

        return $this->response->withItem($book, new BookTransformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int         $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'author' => 'required|exists:authors,id',
        ]);

        $book = Book::find($id);

        if (! $book) {
            return $this->response->withNotFound();
        }

        $book->fill($request->all())
            ->author()
            ->associate($request->author)
            ->save();

        return $this->response->withItem($book, new BookTransformer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        if (! $book) {
            return $this->response->withNotFound();
        }

        $book->delete();

        return $this->response->withNoContent();
    }
}
