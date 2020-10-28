<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStateRequest;
use App\Models\State;

/**
 * Class StatesController
 *
 * @author lacal
 */
class StatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return State
     */
    public function index()
    {
        return State::orderBy('name', 'asc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreStateRequest $request
     * @return State
     */
    public function store(StoreStateRequest $request)
    {
        return State::create($request->only(['name']));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return State
     */
    public function show($id)
    {
        return State::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreStateRequest $request
     * @param int $id
     * @return State
     */
    public function update(StoreStateRequest $request, $id)
    {
        $state = State::findOrFail($id);
        $state->update($request->only(['name']));
        return $state;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id)
    {
        // TODO: discuss how to implement delete in states
    }
}
