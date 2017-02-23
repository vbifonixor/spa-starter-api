<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class BooksController extends Controller
{
    /**
     * Creates a new class instance.
     */
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = (int) $request->query('limit', 10);
        $include = $request->query('include');
        $sort = $request->query('sort');
        $order = $request->query('order_by');

        $books = Book::take($limit)->orderBy($sort, $order);

        if ($include == 'author') {
            $books = $books->with('author');
        }

        $books = $books->get();

        $pagination = new LengthAwarePaginator($books, Book::count(), $limit);

        return response()->json([
            'data' => $books,
            'metadata' => [
                'pagination' => array_except($pagination->toArray(), 'data'),
            ],
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        $book = new Book($request->all());

        $book->author()
            ->associate($request->author)
            ->save();

        $book->load('author');

        return response()->json([
            'data' => $book,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $book = Book::find($id);

        if (! $book) {
            return response()->json([
                'errors' => ['Book not found.'],
            ], 404);
        }

        if ($request->query('include') == 'author') {
            $book->load('author');
        }

        return response()->json([
            'data' => $book,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, $id)
    {
        $book = Book::find($id);

        if (! $book) {
            return response()->json([
                'errors' => ['Book not found.'],
            ], 404);
        }

        $book->fill($request->all())
            ->author()
            ->associate($request->author)
            ->save();

        $book->load('author');

        return response()->json([
            'data' => $book,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        if (! $book) {
            return response()->json([
                'errors' => ['Book not found.'],
            ], 404);
        }

        $book->delete();

        return response()->json([], 204);
    }
}
