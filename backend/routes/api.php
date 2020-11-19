<?php

use App\Models\Event;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//first
Auth::routes();

Auth::routes(['verify' => true]);

/*
 * Prefix for user authentication routes
 */
Route::prefix('users')->group(function () {
    Route::post('login', 'Api\UsersVerificationController@login');
    Route::post('register', 'Api\UsersVerificationController@register');
    Route::get('email/resend', 'Auth\VerificationApiController@resend')->name('verificationapi.resend');
    Route::get('email/verify/{id}', 'Auth\VerificationApiController@verify')->name('verificationapi.verify')->middleware('signed');

    // password reset routes
    Route::group(['namespace' => 'Auth', 'middleware' => 'api', 'prefix' => 'password'], function () {
        Route::post('create', 'PasswordResetController@create');
        Route::get('find/{token}', 'PasswordResetController@find');
        Route::post('reset', 'PasswordResetController@reset');
    });

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('details', 'Api\UsersVerificationController@details')->middleware('verified');
        Route::get('logout', 'Api\UsersVerificationController@logout')->middleware('verified');
    }); // will work only when user has verified the email

    //User registration on events
    Route::post('eventRegister', 'Api\UsersController@eventRegister');
    Route::post('eventUnregister', 'Api\UsersController@eventUnregister');
    Route::post('eventEmail', 'Api\UsersController@eventEmail')->name('users.email');
});

Route::namespace('Api')->group(function () {
    Route::apiResource('categories', 'CategoriesController');
    Route::apiResource('cities', 'CitiesController');
    Route::apiResource('departments', 'DepartmentsController');
    Route::apiResource('events', 'EventsController');
    Route::apiResource('faculties', 'FacultiesController');
    Route::apiResource('pictures', 'PicturesController');
    Route::apiResource('places', 'PlacesController');
    Route::apiResource('roles', 'RolesController');
    Route::apiResource('states', 'StatesController');
    Route::apiResource('users', 'UsersController');
});

/**
 * Route for filtering events according parameters
 *
 * @author lacal
 */
Route::get('events', function () {

    // get 'events' with pivot table 'event_user'
    $query = Event::with('user', 'place', 'department', 'faculty', 'categories')
        ->select('events.*', DB::raw('COUNT(event_user.event_id) as participants'))
        ->leftJoin('event_user', 'events.id', '=', 'event_user.event_id');

    // Find out if request contains 'filter' value
    if (\request()->filled('filter')) {

        // explode request according ','
        $filters = explode(',', \request('filter'));

        // this value determines, if query should be sorted according actual time, or custom time given by user
        $datetimeFilter = true;

        foreach ($filters as $filter) {

            // explode request according '=' on criteria and value
            [$criteria, $value] = explode('=', $filter);

            if ($criteria == 'beginning') {
                $query->where($criteria, '>=', $value);
                $datetimeFilter = false;
            } elseif ($criteria == 'end') {
                $query->where('beginning', '<=', $value);
                $datetimeFilter = false;
            } elseif ($criteria == 'limit') {
                $query->havingRaw('participants != attendance_limit');
            } elseif (strpos($criteria, 'id_') !== false) {
                if ($criteria == 'id_user') $query->where('events.id_user', '=', $value);
                else $query->where($criteria, '=', $value);
            } elseif ($criteria == 'event_user_id') {
                $query->where('event_user.user_id', '=', $value);
                $datetimeFilter = false;
            } else {
                if ($criteria == 'name') $query->where('events.name', 'like', '%' . $value . '%');
                else $query->where($criteria, 'like', '%' . $value . '%');
            }
        }
        if ($datetimeFilter) $query->where('beginning', '>=', date('Y-m-d H:i:s'));

        // return filter query
        return $query
            ->groupBy('events.id')
            ->orderBy('beginning', 'asc')
            ->simplePaginate(12);
    } else {

        // return query with no filter value
        return $query
            ->where('beginning', '>=', date('Y-m-d H:i:s'))
            ->groupBy('events.id')
            ->orderBy('beginning', 'asc')
            ->paginate(12);
    }
});
