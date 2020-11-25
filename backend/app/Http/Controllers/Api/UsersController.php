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
        $this->middleware('auth:api', ['scopes: admin-user'])
            ->except(['eventRegister', 'eventUnregister', 'eventEmail']);
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
            $event = Event::findOrFail($request->input('event_id'));
            $event->attendance()->attach($request->input('user_id'));

            return response()->json([
                'success' => true,
                'message' => 'User was successfully registered on event'],
                201);
        } elseif ($request->input('user_id') == null) {

            $eventid = $request->input('event_id');
            $mail = $request->input('email');
            Mail::to($mail)
                ->send(new EventRegister(
                    $eventid, $mail
                ));
            return response()->json([
                'success' => true,
                'message' => 'Email send'],
                201);
        }


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
            $event = Event::findOrFail($request->input('event_id'));
            $mail = Email::where('email', '=', $request->input('email'))->firstOrFail();
            $event->emails()->detach($mail->id);

            return response()->json([
                'success' => true,
                'message' => 'Email was successfully removed from event'],
                200);
        }

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function eventEmail(Request $request)
    {

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
}
