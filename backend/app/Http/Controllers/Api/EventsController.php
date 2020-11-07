<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

/**
 * Class EventsController
 *
 * @author lacal
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
     * StoreFacultyRequest $request
     * * @return Event
     */
    public function store(Request $request)
    {
        if ($request->input('id_repeat') === null) {
            return Event::create($request->only([
                'name',
                'desc',
                'room',
                'beginning',
                'end',
                'attendance_limit',
                'id_user',
                'id_place',
                'id_faculty',
                'id_department',
            ]));
        }

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
        $event->update($request->only([
            'name',
            'desc',
            'room',
            'beginning',
            'end',
            'attendance_limit',
            'id_user',
            'id_place',
            'id_faculty',
            'id_department'

        ]));
        return $event;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

    }
}
