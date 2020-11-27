<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\EmailVerifyRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Class VerificationApiController
 *
 * @author lacal
 */
class VerificationApiController extends Controller
{
    use VerifiesEmails;

    /**
     * Show the email verification notice.
     *
     */
    public function show()
    {
        //
    }

    /**
     * Mark the authenticated user’s email address as verified.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function verify(Request $request)
    {
        $userID = $request['id'];
        $user = User::findOrFail($userID);
        $date = date('Y-m-d g:i:s');

        // to enable the “email_verified_at field of that user be a current timestamp by mimicing the must verify email feature
        $user->email_verified_at = $date;
        $user->save();
        return redirect()->guest(RouteServiceProvider::LOGIN);
    }

    /**
     * Resend the email verification notification.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json('User already have verified email!', 422);
            // return redirect($this->redirectPath());
        }
        $request->user()->notify(new EmailVerifyRequest());
        return response()->json('The notification has been resubmitted');
        // return back()->with(‘resent’, true);
    }
}
