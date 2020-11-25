<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlaceRequest;
use App\Models\Place;

/**
 * Class PlacesController
 *
 * @author lacal
 */
class PlacesController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api', ['scopes: admin-user,moderator-user'])->except(['index', 'show']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Place
     */
    public function index()
    {
        return Place::orderBy('name', 'asc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePlaceRequest $request
     * @return Place
     */
    public function store(StorePlaceRequest $request)
    {
        return Place::create($request->only(['name', 'id_city']));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Place
     */
    public function show($id)
    {
        return Place::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StorePlaceRequest $request
     * @param int $id
     * @return Place
     */
    public function update(StorePlaceRequest $request, $id)
    {
        $place = Place::findOrFail($id);
        $place->update($request->only(['name', 'id_city']));
        return $place;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     */
    public function destroy($id)
    {
        // TODO: discuss how to implement delete in cities
    }
}
