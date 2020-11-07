<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePictureRequest;
use App\Models\Picture;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PicturesController
 *
 * @author lacal
 */
class PicturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Picture
     */
    public function index()
    {
        return Picture::orderBy('id', 'asc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePictureRequest $request
     * @return Picture
     */
    public function store(StorePictureRequest $request)
    {
        return Picture::create($request->only(['link', 'id_event']));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Picture
     */
    public function show($id)
    {
        return Picture::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StorePictureRequest $request
     * @param int $id
     * @return Picture
     */
    public function update(StorePictureRequest $request, $id)
    {
        $picture = Picture::findOrFail($id);
        $picture->update($request->only(['link', 'id_event']));
        return $picture;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Soft delete picture
        Picture::findOrFail($id)->delete();

        return response()->noContent(Response::HTTP_ACCEPTED);
    }
}
