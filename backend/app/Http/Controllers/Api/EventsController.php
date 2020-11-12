<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

/**
 * Class EventsController
 *
 * @author lacal, klukak
 */
class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Event
     */
    public function index()
    {
        return Event::orderBy('beginning', 'asc')->paginate(12);
    }

    /**
     * Store a newly created resource in storage.
     * * @return Event, Category
     */
    public function store(Request $request)
    {


        $event = new Event();

        $event->name = $request->input('name');
        $event->desc = $request->input('desc');
        $event->room = $request->input('room');
        $event->beginning = $request->input('beginning');
        $event->end = $request->input('end');
        $event->attendance_limit = $request->input('attendance_limit');
        $event->id_user = $request->input('id_user');
        $event->id_place = $request->input('id_place');
        $event->id_faculty = $request->input('id_faculty');
        $event->id_department = $request->input('id_department');
        $event->save();


        foreach ($request->input("categories") AS $category) {
            $category = Category::firstOrCreate(["name" => $category['name']]);
            $event->categories()->attach($category->id);


        }

        return response()->json([
            'success' => true,
            'message' => 'Event was created successfully',
            'event' => $event],
            201);

    }

    /**
     * Display the specified resource.
     * @param $id
     * @return Event
     */
    public function show($id)
    {
        return Event::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $event = Event::findOrFail($id);


        $event->name = $request->input('name');
        $event->desc = $request->input('desc');
        $event->room = $request->input('room');
        $event->beginning = $request->input('beginning');
        $event->end = $request->input('end');
        $event->attendance_limit = $request->input('attendance_limit');
        $event->id_user = $request->input('id_user');
        $event->id_place = $request->input('id_place');
        $event->id_faculty = $request->input('id_faculty');
        $event->id_department = $request->input('id_department');
        $event->save();

        $arr = [];
        foreach ($request->input("categories") AS $category) {
            $category = Category::firstOrCreate(["name" => $category['name']]);

            array_push($arr, $category->id);

        }

        $event->categories()->sync($arr);


        return response()->json([
            'success' => true,
            'message' => 'Event was updated successfully',
            'event' => $event], 200);

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

    }
}
