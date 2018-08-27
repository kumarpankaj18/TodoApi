<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Route::resource('tasks', 'TasksController')->only(['show','update','destroy','store', 'index']);
Route::resource('user', 'UserController')->only(['show','destroy','update','store', 'index']);

Route::get('/user/{user_id}/tasks', 'TasksController@getUserTasks');
Route::put('/tasks/{id}/updateStatus', 'TasksController@updateTaskStatus');
