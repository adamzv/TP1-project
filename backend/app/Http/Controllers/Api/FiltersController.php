<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFilterRequest;
use App\Models\Filter;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FiltersController
 *
 * @author lacal
 */
class FiltersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Filter
     */
    public function index()
    {
        return Filter::orderBy('name', 'asc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFilterRequest $request
     * @return Filter
     */
    public function store(StoreFilterRequest $request)
    {
        return Filter::create($request->only(['name']));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Filter
     */
    public function show($id)
    {
        return Filter::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreFilterRequest $request
     * @param int $id
     * @return Filter
     */
    public function update(StoreFilterRequest $request, $id)
    {
        $filter = Filter::findOrFail($id);
        $filter->update($request->only(['name']));
        return $filter;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Soft delete Filter with cascade
        Filter::findOrFail($id)->delete();

        return response()->noContent(Response::HTTP_ACCEPTED);
    }
}
