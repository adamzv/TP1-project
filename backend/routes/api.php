<?php

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

/*
 * Prefix for user authentication routes
 */
Route::prefix('users')->group(function () {
    Route::post('login', 'Api\UsersController@login');
    Route::post('register', 'Api\UsersController@register');
    Route::get('logout', 'Api\UsersController@logout')->middleware('auth:api');
});

Route::namespace('Api')->group(function () {
    Route::apiResource('categories', 'CategoriesController');
    Route::apiResource('cities', 'CitiesController');
    Route::apiResource('departments', 'DepartmentsController');
    Route::apiResource('events', 'EventsController');
    Route::apiResource('faculties', 'FacultiesController');
    Route::apiResource('filters', 'FiltersController');
    Route::apiResource('pictures', 'PicturesController');
    Route::apiResource('places', 'PlacesController');
    Route::apiResource('repeats', 'RepeatsController');
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
    $query = DB::table('events')
        ->select('events.*', DB::raw('COUNT(id_event) as participants'))
        ->leftJoin('event_user', 'events.id', '=', 'event_user.id_event');

    // Find out if request contains 'filter' value
    if (\request()->filled('filter')) {

        // explode request according ','
        $filters = explode(',', \request('filter'));
        $query->groupBy('events.id');

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
                $query->havingRaw('COUNT(id_event) != attendance_limit');
            } elseif (strpos($criteria, 'id_') !== false) {
                if ($criteria == 'id_user') $query->where('events.id_user', '=', $value);
                else $query->where($criteria, '=', $value);
            } else {
                $query->where($criteria, 'like', '%' . $value . '%');
            }
        }
       if ($datetimeFilter) $query->where('beginning', '>=', date('Y-m-d H:i:s'));

       // return filter query
        return $query
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
