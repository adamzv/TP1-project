<?php

use Illuminate\Http\Request;
use \App\Models\Event;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->group(function () {
   Route::apiResource('events', 'EventsController');
});

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

   return $query->paginate(20);
});
