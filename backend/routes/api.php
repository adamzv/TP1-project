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

/*
 * Route for filtering events according parameters
 */
Route::get('events', function () {
    $query = Event::query();

    $query->when(\request()->filled('filter'), function ($query) {
        $filters = explode(',', \request('filter'));

        foreach ($filters as $filter) {
            [$criteria, $value] = explode(':', $filter);
            $query->where($criteria, $value);
        }
        return $query;
    });

    return $query->paginate(12);
});
