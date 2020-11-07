<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class UsersController
 *
 * @author lacal
 */
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return User
     */
    public function index()
    {
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // TODO: discuss with team
    }

    /**
     * Login user
     *
     * @param UserLoginRequest $request
     * @return JsonResponse
     */
    public function login(UserLoginRequest $request)
    {
        // Attempt to login
        if (!Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ])) {
            return response()->json([
                'success' => false,
                'message' => 'You have entered the wrong login information!']);
        }

        // create token to user and return it
        $accessToken = Auth::user()->createToken('authToken')->accessToken;
        return response()->json([
            'success' => true,
            'message' => 'Login was successful',
            'user' => Auth::user(),
            'access_token' => $accessToken]);
    }

    /**
     * Register new user
     *
     * @param UserRegisterRequest $request
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $request)
    {
        // get data from request
        $input = [
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'email' => $request->input('email'),
            'id_role' => Role::where('type', 'pouzivatel')->value('id'),
            'password' => bcrypt($request->input('password')),
        ];

        // create new user
        $user = User::create($input);

        // create token to the user and return it with user
        $accessToken = $user->createToken('authToken')->accessToken;
        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'user' => $user,
            'access_token' => $accessToken]);
    }

    /**
     * Logout user
     *
     * @return JsonResponse
     */
    public function logout()
    {
        if (Auth::user()) {
            $user = Auth::user()->token();
            $user->revoke();

            return response()->json([
                'success' => true,
                'message' => 'Logout successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unable to Logout'
            ]);
        }
    }
}
