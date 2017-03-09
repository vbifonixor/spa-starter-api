<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $limit = $this->parameters->limit(10);
        $include = $this->parameters->include();
        $sort = $this->parameters->sortBy('id');
        $order = $this->parameters->orderBy('desc');

        $books = Book::take($limit)->orderBy($sort, $order);

        if ($include) {
            $books = $books->with($include);
        }

        $books = $books->get();

        $pagination = new LengthAwarePaginator($books, Book::count(), $limit);

        return $this->response->withResource($books, [
            'pagination' => array_except($pagination->toArray(), 'data'),
        ]);
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

        $book->load('author');

        return $this->response->withCreated($book);
    }

    /**
     * Display the specified resource.
     *
     * @param  Request $request
     * @param  int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $include = $this->parameters->include();
        $book = ($include) ? Book::with($include)->find($id) : Book::find($id);

        if (! $book) {
            return $this->response->withNotFound();
        }

        return $this->response->withResource($book);
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

        $book->load('author');

        return $this->response->withResource($book);
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
