<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AuthorsController extends Controller
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
        $limit = (int) $request->query('limit', 10);
        $include = $request->query('include');
        $sort = $request->query('sort', 'id');
        $order = $request->query('order_by', 'desc');

        $authors = Author::take($limit)->orderBy($sort, $order);

        if ($include) {
            $authors = $authors->with($include);
        }

        $authors = $authors->get();

        $pagination = new LengthAwarePaginator($authors, Author::count(), $limit);

        return $this->response->withResource($authors, [
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
            'name' => 'required',
        ]);

        $author = Author::create([
            'name' => $request->name,
        ]);

        return $this->response->withCreated($author);
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
            return $this->response->withNotFound();
        }

        return $this->response->withResource($author);
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

        return $this->response->withResource($author);
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
