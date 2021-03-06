<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Mail\EventChanged;
use App\Models\Category;
use App\Models\City;
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


    public function admin(){
        $query = Event::with('user', 'place', 'department', 'faculty', 'categories')
            ->select('events.*', DB::raw('COUNT(event_user.event_id) as participants'))
            ->leftJoin('event_user', 'events.id', '=', 'event_user.event_id')
            ->leftjoin('category_event', 'category_event.event_id', '=', 'events.id')
            ->groupBy('events.id')
            ->orderBy('beginning', 'asc')
            ->get();
        return $query;


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
        if($request->input('id_place') != null){
            $event->id_place = $request->input('id_place');
        }
        else{
            $city =  City::firstOrCreate(["name" => $request->input('city')],['id_state' => 1]);
            $place = Place::firstOrCreate(["name" => $request->input('street'), 'id_city' => $city->id]);
            $event->id_place = $place->id;

        };
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
        //$event->id_user = $request->input('id_user');
        if($request->input('id_place') != null){
            $event->id_place = $request->input('id_place');
            $place = Place::findOrFail($request->input('id_place'));
        }
        else{
            $city =  City::firstOrCreate(["name" => $request->input("city")],['id_state' => 1]);
            $place = Place::firstOrCreate(["name" => $request->input('street'), 'id_city' => $city->id]);
            $event->id_place = $place->id;

        };
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
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        // find event
        $event = Event::findOrFail($id);

        // detach categories from event
        $event->categories()->detach();

        // inform users only if event time is actual
        if ($event->beginning >= date('Y-m-d H:i:s')) {

            // create and send mail to users about deletion of event
            Mail::to('me@app.com')
                ->bcc($this->getUsersOfEvent($id))
                ->send(new EventChanged(
                    $event,
                    'delete',
                    $event->beginning
                ));
        }

        // detach users from event
        $event->attendance()->detach();

        // soft delete event
        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event was successfully deleted'],
            200);
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
