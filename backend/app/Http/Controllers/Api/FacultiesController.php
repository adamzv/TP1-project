<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFacultyRequest;
use App\Models\Faculty;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FacultiesController
 *
 * @author lacal
 */
class FacultiesController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth:api', 'scope:admin-user,moderator-user'])->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Faculty
     */
    public function index()
    {
        return Faculty::orderBy('name', 'asc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFacultyRequest $request
     * @return Faculty
     */
    public function store(StoreFacultyRequest $request)
    {
        return Faculty::create($request->only(['name']));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Faculty
     */
    public function show($id)
    {
        return Faculty::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreFacultyRequest $request
     * @param int $id
     * @return Faculty
     */
    public function update(StoreFacultyRequest $request, $id)
    {
        $faculty = Faculty::findOrFail($id);
        $faculty->update($request->only(['name']));
        return $faculty;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Soft delete faculty with cascade
        Faculty::findOrFail($id)->delete();

        return response()->noContent(Response::HTTP_ACCEPTED);
    }
}
