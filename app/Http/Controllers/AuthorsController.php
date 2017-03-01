<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

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
     * @param  Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $limit = (int) $request->query('limit', 10);
        $include = $request->query('include');
        $sort = $request->query('sort');
        $order = $request->query('order_by');

        $authors = Author::take($limit)->orderBy($sort, $order);

        if ($include) {
            $authors = $authors->with($include);
        }

        $authors = $authors->get();

        $pagination = new LengthAwarePaginator($authors, Author::count(), $limit);

        return response()->json([
            'data' => $authors,
            'metadata' => [
                'pagination' => array_except($pagination->toArray(), 'data'),
            ],
        ], 200);
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
            'name' => 'required',
        ]);

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
     * @param  Request $request
     * @param  int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $include = $request->query('include');
        $author = ($include) ? Author::with($include)->find($id) : Author::find($id);

        if (! $author) {
            return response()->json([
                'errors' => ['Not found.'],
            ], 404);
        }

        return response()->json([
            'data' => $author,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

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
     *
     * @return \Illuminate\Http\JsonResponse
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
