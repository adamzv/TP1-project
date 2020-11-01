<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRepeatRequest;
use App\Models\Repeat;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RepeatsController
 *
 * @author lacal
 */
class RepeatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Repeat
     */
    public function index()
    {
        return Repeat::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRepeatRequest $request
     * @return Repeat
     */
    public function store(StoreRepeatRequest $request)
    {
        return Repeat::create($request->only([
            'repeatUnit', 'repeatNumber', 'repeatUntil']));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Repeat
     */
    public function show($id)
    {
        return Repeat::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreRepeatRequest $request
     * @param int $id
     * @return Repeat
     */
    public function update(StoreRepeatRequest $request, $id)
    {
        $repeat = Repeat::findOrFail($id);
        $repeat->update($request->only([
            'repeatUnit', 'repeatNumber', 'repeatUntil']));
        return $repeat;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Soft delete Repeat
        Repeat::findOrFail($id)->delete();

        return response()->noContent(Response::HTTP_ACCEPTED);
    }
}
