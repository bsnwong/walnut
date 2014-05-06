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
        return View::make('home.user');
    }
    else {
        return View::make('home.public');
    }
});
Route::get('home', 'HomeController@showHome');

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
 |show the register page
 |---------------------------------------------------------------------
 * */
Route::get('register', function() {
   return View::make('admin.register');
});
/*
 |---------------------------------------------------------------------
 |show the register page
 |---------------------------------------------------------------------
 * */
Route::post('register', 'AdminController@register');
/*
 |---------------------------------------------------------------------
 |go to the login page
 |---------------------------------------------------------------------
 * */
Route::get('login', 'AdminController@judgeUser');
/*
 |---------------------------------------------------------------------
 |get the form data of login page
 |---------------------------------------------------------------------
 * */
Route::post('login', 'AdminController@judgeUser');
/*
 |---------------------------------------------------------------------
 |
 |
 |
 |---------------------------------------------------------------------
 * */
Route::post('org/{node}', 'AdminController@queryOrg');
