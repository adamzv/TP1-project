<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCityRequest;
use App\Models\City;

/**
 * Class CitiesController
 *
 * @author lacal
 */
class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return City
     */
    public function index()
    {
        return City::orderBy('name', 'asc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCityRequest $request
     * @return City
     */
    public function store(StoreCityRequest $request)
    {
        return City::create($request->only(['name', 'id_state']));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return City
     */
    public function show($id)
    {
        return City::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreCityRequest $request
     * @param int $id
     * @return City
     */
    public function update(StoreCityRequest $request, $id)
    {
        $city = City::findOrFail($id);
        $city->update($request->only(['name', 'id_state']));
        return $city;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * TODO: discuss how to implement delete in cities
     */
    public function destroy($id)
    {

    }
}
