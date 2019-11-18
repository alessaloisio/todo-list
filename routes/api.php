<?php

use Illuminate\Http\Request;

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

// ROOT
Route::get('/', function (Request $request) {
    return response()->json([
        "version" => "1.0"
    ]);
});

// AUTHENTICATION
Route::post('/auth/login', 'API\AuthController@login');
Route::post('/auth/register', 'API\AuthController@register');

// Protected with APIToken Middleware
Route::middleware('APIToken')->group(function () {
    // Logout
    Route::get('/auth/logout', 'API\AuthController@logout');

    /*
     * PROJECTS
     */
    Route::get('/projects', 'API\ProjectController@index');

    Route::post('/project', 'API\ProjectController@store');
    Route::get('/project/{id}', 'API\ProjectController@show')->where('id', '[0-9]+');
    Route::post('/project/{id}', 'API\ProjectController@update')->where('id', '[0-9]+');
    Route::delete('/project/{id}', 'API\ProjectController@destroy')->where('id', '[0-9]+');

    // LISTS
    Route::get('/project/{project_id}/lists/', 'API\ListTaskController@index')
        ->where('project_id', '[0-9]+');

    Route::post('/project/{project_id}/list/', 'API\ListTaskController@store')
        ->where('project_id', '[0-9]+');

    Route::get('/project/{project_id}/list/{list_id}', 'API\ListTaskController@show')
        ->where('project_id', '[0-9]+')
        ->where('list_id', '[0-9]+');

    Route::post('/project/{project_id}/list/{list_id}', 'API\ListTaskController@update')
        ->where('project_id', '[0-9]+')
        ->where('list_id', '[0-9]+');

    Route::delete('/project/{project_id}/list/{list_id}', 'API\ListTaskController@destroy')
        ->where('project_id', '[0-9]+')
        ->where('list_id', '[0-9]+');

    // TASKS
    Route::get('/project/{project_id}/list/{list_id}/tasks/', 'API\TaskController@index')
        ->where('project_id', '[0-9]+')
        ->where('list_id', '[0-9]+');

    Route::post('/project/{project_id}/list/{list_id}/task/', 'API\TaskController@store')
        ->where('project_id', '[0-9]+')
        ->where('list_id', '[0-9]+');

    Route::get('/project/{project_id}/list/{list_id}/task/{task_id}', 'API\TaskController@show')
        ->where('project_id', '[0-9]+')
        ->where('list_id', '[0-9]+')
        ->where('task_id', '[0-9]+');

    Route::post('/project/{project_id}/list/{list_id}/task/{task_id}', 'API\TaskController@update')
        ->where('project_id', '[0-9]+')
        ->where('list_id', '[0-9]+')
        ->where('task_id', '[0-9]+');

    Route::delete('/project/{project_id}/list/{list_id}/task/{task_id}', 'API\TaskController@destroy')
        ->where('project_id', '[0-9]+')
        ->where('list_id', '[0-9]+')
        ->where('task_id', '[0-9]+');


});
