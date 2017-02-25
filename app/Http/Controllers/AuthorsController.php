<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use App\Http\Requests\AuthorRequest;

class AuthorsController extends Controller
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
    public function index()
    {
        $authors = Author::all();

        return response()->json([
            'data' => $authors,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AuthorRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AuthorRequest $request)
    {
        $author = Author::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'data' => $author,
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
        $author = Author::find($id);

        if (! $author) {
            return response()->json([
                'errors' => ['Not found.'],
            ], 404);
        }

        if ($request->query('include') == 'books') {
            $author->load('books');
        }

        return response()->json([
            'data' => $author,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AuthorRequest $request, $id)
    {
        $author = Author::find($id);

        if (! $author) {
            return response()->json([
                'errors' => ['Not found.'],
            ], 404);
        }

        $author->fill([
            'name' => $request->name,
        ])->save();

        return response()->json([
            'data' => $author,
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
        $author = Author::find($id);

        if (! $author) {
            return response()->json([
                'errors' => ['Not found.'],
            ], 404);
        }

        $author->delete();

        return response()->json(null, 204);
    }
}
