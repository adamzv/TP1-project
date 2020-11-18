<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class PasswordResetController
 *
 * @author lacal
 */
class PasswordResetController extends Controller
{
    /**
     * Create token password reset
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        // get email from request
        $request->validate([
            'email' => 'required|string|email|max:255',
        ]);

        // find user with given email address (email address should be unique)
        $user = User::where('email', $request->email)->first();

        // if user doesnt exist
        if (!$user)
            return response()->json([
                'message' => 'User with given e-mail address doesnt exist.'], 404);

        // create random token
        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            ['email' => $user->email, 'token' => Str::random(60)]);

        if ($user && $passwordReset)
            $user->notify(new PasswordResetRequest($passwordReset->token));

        // return json response
        return response()->json([
            'message' => 'Password reset link was send on given email address.'
        ]);
    }

    /**
     * Find token password reset
     *
     * @param $token
     * @return JsonResponse
     */
    public function find($token)
    {
        // get password reset token
        $passwordReset = PasswordReset::where('token', $token)->first();

        // if doesnt exist
        if (!$passwordReset)
            return response()->json([
                'message' => 'This password reset token doesnt exist.'], 404);

        // if token is expired
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                'message' => 'This password reset token expired.'], 404);
        }

        return response()->json($passwordReset);
    }

    /**
     * Reset password
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function reset(Request $request)
    {
        // validate request
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|max:255|confirmed',
            'token' => 'required|string'
        ]);

        // find given token and email in db
        $passwordReset = PasswordReset::where([
            ['token', $request->input('token')], ['email', $request->input('email')]])->first();

        // if nothing was found
        if (!$passwordReset)
            return response()->json([
                'success' => false,
                'message' => 'Password reset token doesnt exist.'], 404);

        // find user according given email address (should be unique per user)
        $user = User::where('email', $passwordReset->email)->first();

        // if no user was found
        if (!$user)
            return response()->json([
                'success' => false,
                'message' => 'User with that email address doesnt exist.'], 404);

        // crypt given password and save it
        $user->password = bcrypt($request->password);
        $user->save();

        // delete reset token from db
        $passwordReset->delete();

        // inform user
        $user->notify(new PasswordResetSuccess($passwordReset));
        return response()->json([
            'success' => true,
            'message' => 'Password was changed successfully!',
            $user]);
    }
}
