<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*
 * Will show the home page if is login, otherwise the login page
 * */
Route::get('/', function()
{
    $user = Session::get('user');
    if($user) {
        return View::make('home');
    }
    else {
        return View::make('login');
    }
});

Route::get('about', function() {
    exit;
    $users = User::all()->count();
    $view = View::make('home.about');
    $view->greeting = 'hi';
    $view->who = 'everyone';
    $view->user = $users;
    $new = new User;
    $new->name = 'hello';
    $new->save();
    return $view;
});
/*
 |---------------------------------------------------------------------
 |
 |
 |
 |---------------------------------------------------------------------
 * */
Route::get('register', function() {
   return View::make('');
});
Route::post('login', 'LoginController@judgeUser');
