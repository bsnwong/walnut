<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('home.about');
	}

    public function showHome() {
        //test whether the user has logged in
        $user = Session::get('user');
        if($user) {
            $view = View::make('home.user');
            $view->user = $user;
        }
        else {
            $view = View::make('home.public');
        }
        return $view;
    }

}