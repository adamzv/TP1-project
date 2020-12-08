<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Mail\EventChanged;
use App\Models\Category;
use App\Models\Event;
use App\Models\Place;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Mail;

/**
 * Class EventsController
 *
 * @author lacal, klukak
 */
class EventsController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth:api', 'scope:admin-user,moderator-user'])->except(['index', 'show']);
    }

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
     * @param StoreEventRequest $request
     * @return JsonResponse
     */
    public function store(StoreEventRequest $request)
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

        // find if files paths exists in request
        if ($request->has('pdfPath')) {
            $pdfFile = $request->input('pdfPath');

            // if path is not null
            if (!empty($pdfFile) && $pdfFile != 'null') $this->movePdfPath($event->id, $pdfFile);
        }
        if ($request->has('titleImgPath')) {
            $titleImageFile = $request->input('titleImgPath');
            if (!empty($titleImageFile) && $titleImageFile != 'null') $this->moveTitleImagePath($event->id, $titleImageFile);
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
     * @param StoreEventRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreEventRequest $request, $id)
    {
        $event = Event::findOrFail($id);

        // save the old values of event (place and time)
        $eventPlaceOld = $event->id_place;
        $eventBeginningOld = $event->beginning;

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

        // find if files paths exists in request
        if ($request->has('pdfPath')) {
            $pdfFile = $request->input('pdfPath');

            // if path is not null
            if (!empty($pdfFile) && $pdfFile != 'null') $this->movePdfPath($event->id, $pdfFile);

        }
        if ($request->has('titleImgPath')) {
            $titleImageFile = $request->input('titleImgPath');
            if (!empty($titleImageFile) && $titleImageFile != 'null') $this->moveTitleImagePath($event->id, $titleImageFile);
        }

        $arr = [];
        foreach ($request->input("categories") as $category) {
            $category = Category::firstOrCreate(["name" => $category['name']]);
            array_push($arr, $category->id);
        }

        $event->categories()->sync($arr);

        if ($eventPlaceOld != $request->input('id_place') &&
            $eventBeginningOld != $request->input('beginning')) {

            // find the place
            $place = Place::findOrFail($request->input('id_place'));

            // create and send mail
            Mail::to('me@app.com')
                ->bcc($this->getUsersOfEvent($id))
                ->send(new EventChanged(
                    $event,
                    'both',
                    $place->name
                ));

            // if only place or time was updated
        } elseif ($eventPlaceOld != $request->input('id_place')) {

            // find the place
            $place = Place::findOrFail($request->input('id_place'));

            // create and send mail
            Mail::to('me@app.com')
                ->bcc($this->getUsersOfEvent($id))
                ->send(new EventChanged(
                    $event,
                    'place',
                    $place->name
                ));
        } elseif ($eventBeginningOld != $request->input('beginning')) {

            // create and send mail
            Mail::to('me@app.com')
                ->bcc($this->getUsersOfEvent($id))
                ->send(new EventChanged(
                    $event,
                    'beginning',
                    $request->input('beginning')
                ));
        }

        return response()->json([
            'success' => true,
            'message' => 'Event was updated successfully',
            'event' => $event], 200);
    }

    /**
     * Method gets users that goes to the event
     *
     * @param $id
     * @return Collection
     */
    public function getUsersOfEvent($id)
    {
        return User::query()
            ->leftjoin('event_user', 'event_user.user_id', '=', 'users.id')
            ->where('event_user.event_id', '=', $id)
            ->get();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // TODO: while implementing destroy method, its also important to send mail to registered users to this event.
    }

    /**
     * Move pdf file from one path to another
     *
     * @param $id
     * @param $path
     */
    public function movePdfPath($id, $path)
    {
        $fileNmae = basename($path);
        \Storage::disk('azure')->move($path, 'pdf/' . $id . '/' . $fileNmae);
    }

    /**
     * Move title image from one path to another
     *
     * @param $id
     * @param $path
     */
    public function moveTitleImagePath($id, $path)
    {
        $fileNmae = basename($path);
        \Storage::disk('azure')->move($path, 'titleImg/' . $id . '/' . $fileNmae);
    }
}
