<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CategoriesController
 *
 * @author lacal
 */
class CategoriesController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth:api', 'scope:admin-user,moderator-user'])->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::orderBy('name', 'asc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return Category
     */
    public function store(StoreCategoryRequest $request)
    {
        return Category::create($request->only(['name']));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Category
     */
    public function show($id)
    {
        return Category::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @param $id
     * @return Category
     */
    public function update(StoreCategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->only(['name']));
        return $category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        // Soft delete Category with cascade
        Category::findOrFail($id)->delete();

        return response()->noContent(Response::HTTP_ACCEPTED);
    }
}
