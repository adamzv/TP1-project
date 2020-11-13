<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class EventsController
 *
 * @author lacal, klukak
 */
class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Event
     */
    public function index()
    {
        // gets changed in api.php
        return Event::orderBy('beginning', 'asc')->paginate(12);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
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
        $event->lecturer = $request->input('lecturer');
        $event->id_user = $request->input('id_user');
        $event->id_place = $request->input('id_place');
        $event->id_faculty = $request->input('id_faculty');
        $event->id_department = $request->input('id_department');
        $event->save();

        foreach ($request->input("categories") as $category) {
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
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $event = Event::with('user', 'place', 'department', 'faculty', 'categories')
            ->select('events.*', DB::raw('COUNT(event_user.event_id) as participants'))
            ->leftJoin('event_user', 'events.id', '=', 'event_user.event_id')
            ->groupBy('events.id')
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Event successfully founded',
            'event' => $event]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
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
        $event->lecturer = $request->input('lecturer');
        $event->id_user = $request->input('id_user');
        $event->id_place = $request->input('id_place');
        $event->id_faculty = $request->input('id_faculty');
        $event->id_department = $request->input('id_department');
        $event->save();

        $arr = [];
        foreach ($request->input("categories") as $category) {
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
        // TODO
    }
}
