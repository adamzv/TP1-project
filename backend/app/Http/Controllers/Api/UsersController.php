<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Mail\EventRegister;
use App\Models\Email;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

/**
 * Class UsersController
 *
 * @author lacal, klukak
 */
class UsersController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth:api', 'scope:admin-user'])->except(['eventRegister', 'eventUnregister', 'eventEmail', 'show', 'checkEvent']);
        $this->middleware(['auth:api', 'scope:moderator-user,logged-user,admin-user'])->only(['show','checkEvent']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return User
     */
    public function index()
    {
        // gets caught in api routes
        return User::orderBy('name', 'asc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return User
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->only([
            'name', 'surname', 'email', 'password', 'id_role']));

        // for testing purposes
        $user->makeVisible(['password']);
        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return User
     */
    public function show($id)
    {
        return User::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreUserRequest $request
     * @param int $id
     * @return User
     */
    public function update(StoreUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only([
            'name', 'surname', 'email', 'password', 'id_role']));

        // for testing purposes
        $user->makeVisible(['password']);
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id)
    {
        // TODO: discuss with team
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function eventRegister(Request $request)
    {

        if ($request->input('email') == null) {
            $query = DB::table('event_user')
                ->where('user_id','=',$request->input('user_id'))
                ->where('event_id','=',$request->input('event_id'))
                ->get();
            if($query->isEmpty() && ($this->checkLimit($request->input('event_id')) == true)) {
                $event = Event::findOrFail($request->input('event_id'));
                $event->attendance()->attach($request->input('user_id'));

            return response()->json([
                'success' => true,
                'message' => 'User was successfully registered on event'],
                201);}
            elseif ($this->checkLimit($request->input('event_id')) == false){
                return response()->json([
                    'message' => 'Event Full'],
                    200);
            }
            else{
                return response()->json([
                    'message' => 'User is already registered on event'],
                    200);
            }
        } elseif ($request->input('user_id') == null) {
            $query = DB::table('event_user')
                ->leftJoin('emails','emails.id','=','event_user.email_id')
                ->where('emails.email','=',$request->input('email'))
                ->where('event_id','=',$request->input('event_id'))
                ->get();
            $test = DB::table('users')
                ->select('email')
                ->where('email','=',$request->input('email'))
                ->get();
            if($test->isEmpty() && $query->isEmpty() && ($this->checkLimit($request->input('event_id')) == true)) {
                $eventid = $request->input('event_id');
                $mail = $request->input('email');
                Mail::to($mail)
                    ->send(new EventRegister(
                        $eventid, $mail
                    ));
                return response()->json([
                    'success' => true,
                    'message' => 'Email sent'],
                    201);
            }
            elseif ($this->checkLimit($request->input('event_id')) == false){
                return response()->json([
                    'message' => 'Event Full'],
                    200);
            }
            elseif ($test->isNotEmpty()){
                return response()->json([
                    'message' => 'Please log in!'],
                    200);
            }
            else{
                return response()->json([
                    'message' => 'This email is already registered on this event'],
                    200);
            }
        }
        return response()->json([
            'message' => 'Something went wrong'],
            200);


    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function eventUnregister(Request $request)
    {
        if ($request->input('email') == null) {
            $event = Event::findOrFail($request->input('event_id'));
            $event->attendance()->detach($request->input('user_id'));

            return response()->json([
                'success' => true,
                'message' => 'User was successfully removed from event'],
                200);

        } elseif ($request->input('user_id') == null) {
            $query = DB::table('event_user')
                ->leftJoin('emails','emails.id','=','event_user.email_id')
                ->where('emails.email','=',$request->input('email'))
                ->where('event_id','=',$request->input('event_id'))
                ->get();
            if($query->isEmpty()){
                return response()->json([
                    'message' => 'You are not registered!'],
                    200);

            }
            else{
            $event = Event::findOrFail($request->input('event_id'));
            $mail = Email::where('email', '=', $request->input('email'))->firstOrFail();
            $event->emails()->detach($mail->id);

            return response()->json([
                'success' => true,
                'message' => 'Email was successfully removed from event'],
                200);
        }
        }
        return response()->json([
        'message' => 'Something went wrong'],
        200);

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function eventEmail(Request $request)
    {
        if ($this->checkLimit($request->input('event_id')) == true) {


            $event = Event::findOrFail($request->input('event_id'));
            $mail = Email::firstOrCreate(["email" => $request->input('email')]);
            //$event->emails()->attach($mail->id);
            if (!$event->emails->contains($mail->id)) {
                $event->emails()->save($mail);
            }
            return response()->json([
                'success' => true,
                'message' => 'Email was successfully registered on event'],
                201);
        }

            return response()->json([
                'message' => 'Event Full'],
                200);
    }


    /**
     * @param $eventid
     * @return bool
     */
    public function checkLimit($eventid){

        $count = DB::table('events')
            ->join('event_user','events.id','=','event_user.event_id')
            ->where('events.id','=',$eventid)
            ->pluck(DB::raw('COUNT(event_user.event_id) as participants'));

        $event = DB::table('events')
            ->select('events.id')
            ->where('events.id','=',$eventid)
            ->where('events.attendance_limit','>', $count)
            ->get();

        if($event->isEmpty()){
            return false;
        }
        return true;

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkEvent(Request $request){
        $query = DB::table('event_user')
            ->select('id')
            ->where('event_id','=',$request->input('event_id'))
            ->where('user_id','=',$request->input('user_id'))
            ->get();
        if($query->isEmpty()){

            return response()->json([
                'message' => false],
                200);
        }

        return response()->json([
            'message' => true],
            200);
    }
}
