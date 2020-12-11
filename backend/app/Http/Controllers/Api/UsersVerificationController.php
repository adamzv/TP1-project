<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\Role;
use App\Models\User;
use App\Notifications\EmailVerifyRequest;
use Auth;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;

/**
 * Class UsersVerificationController
 *
 * @author lacal
 */
class UsersVerificationController extends Controller
{
    use VerifiesEmails;

    public $successStatus = 200;

    /**
     * Login api
     *
     * @param UserLoginRequest $request
     * @return JsonResponse
     */
    public function login(UserLoginRequest $request)
    {
        // Attempt to login
        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ])) {
            $user = Auth::user();
            if ($user->email_verified_at !== NULL) {

                // get object token
                $objToken = $this->createUserToken($user);

                // get access token
                $accessToken = $objToken->accessToken;

                $success['message'] = 'Login successfull';

                return response()->json([
                    'success' => true,
                    'message' => $success,
                    'user' => Auth::user(),
                    'access_token' => $accessToken,
                    'expires_at' => strtotime($objToken->token->expires_at)], $this->successStatus);
            } else {
                return response()->json([
                    'error' => 'Please Verify Email'], 401);
            }
        } else {
            return response()->json([
                'error' => 'Unauthorised'], 401);
        }
    }

    /**
     * Creates user token according role
     *
     * @param $userRole
     * @return mixed
     */
    public function createUserToken($user)
    {
        if ($user->role->type == 'admin') {

            // create token to user with admin scope and return it
            return $objToken = $user->createToken('authToken', ['admin-user']);
        } else if ($user->role->type == 'moderator') {

            // create token to user with moderator scope and return it
            return $objToken = $user->createToken('authToken', ['moderator-user']);
        } else {

            // create token to user and return it
            return $objToken = $user->createToken('authToken', ['logged-user']);
        }
    }

    /**
     * Register api
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

        $user->notify(new EmailVerifyRequest());

        $success['message'] = 'Please confirm yourself by clicking on verify user button sent to you on your email';

        return response()->json([
            'success' => true,
            'message' => $success,
            'user' => $user,
            'access_token' => $accessToken], $this->successStatus);
    }

    /**
     * Logout user
     *
     * @return JsonResponse
     */
    public function logout()
    {
        if (Auth::user()) {
            Auth::user()->tokens->each(function ($token) {
                $token->delete();
            });


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

    /**
     * Details api
     *
     * @return JsonResponse
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json([
            'success' => $user], $this->successStatus);
    }

    /**
     * Refreshes users personal token
     *
     * @return JsonResponse
     */
    public function refreshToken()
    {
        if (Auth::user()) {
            $user = Auth::user();

            // remove old tokens from user
            $user->tokens->each(function ($token) {
                $token->delete();
            });

            // get new object token
            $objToken = $this->createUserToken($user);

            // create new access token
            $accessToken = $objToken->accessToken;

            return response()->json([
                'success' => true,
                'message' => 'Successfully returned new token',
                'user' => $user,
                'access_token' => $accessToken,
                'expires_at' => strtotime($objToken->token->expires_at)], $this->successStatus);

        } else {
            return response()->json([
                'error' => 'Token doesnt existss'], 401);
        }
    }
}
