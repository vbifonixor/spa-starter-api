<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use App\Transformers\AuthorTransformer;

class AuthorsController extends Controller
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

        $authors = Author::orderBy($sort, $order)->paginate($limit);

        return $this->response->withPagination($authors, new AuthorTransformer);
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

        return $this->response->withCreated($author, new AuthorTransformer);
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
        $author = Author::find($id);

        if (! $author) {
            return $this->response->withNotFound();
        }

        return $this->response->withItem($author, new AuthorTransformer);
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
            return $this->response->withNotFound();
        }

        $author->fill([
            'name' => $request->name,
        ])->save();

        return $this->response->withItem($author, new AuthorTransformer);
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
            return $this->response->withNotFound();
        }

        $author->delete();

        return $this->response->withNoContent();
    }
}
