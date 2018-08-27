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
use Illuminate\Support\Facades\DB;


Route::get('/', function () {
    $users = \App\User::where('user_id','abcdfs')->get();
    $user = "";
    foreach($users as $user){
     //   var_dump($user->tasks);
    }
    return $user->tasks;
});

Route::resource('todo', 'TodoListController')->only(['show','update','destroy','store']);
Route::resource('user', 'UserController')->only(['show','destroy']);


Route::put('/user/{id?}', 'UserController@update');
Route::post('/user/', 'UserController@store');
