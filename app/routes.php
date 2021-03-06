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
Route::get('/', function() {
    if(Auth::check()) {
        if(Auth::user()->type == 1) {
            return View::make('home.user');
        }
        elseif(Auth::user()->type == 0) {
            return View::make('home.manage');
        }
    }
    else {
        return Redirect::to('/tips/'.'您还未登录...');
    }
});
Route::get('/home',  function() {
    if(Auth::check()) {
        if(Auth::user()->type == 1) {
            return View::make('home.user');
        }
        elseif(Auth::user()->type == 0) {
            return View::make('home.manage');
        }
    }
    else {
        return Redirect::to('/tips/'.'您还未登录...');
    }
});

Route::get('/about', function() {
    return View::make('home.about');
});
/*
 |---------------------------------------------------------------------
 |show the register page
 |---------------------------------------------------------------------
 * */
Route::get('/register', function() {
   return View::make('admin.register');
});
/*
 |---------------------------------------------------------------------
 |show the register page
 |---------------------------------------------------------------------
 * */
Route::post('/register', 'AdminController@register')->before('csrf');
/*
 |---------------------------------------------------------------------
 |go to the login page
 |---------------------------------------------------------------------
 * */
Route::get('/login', 'AdminController@checkUser');
/*
 |---------------------------------------------------------------------
 |get the form data of login page
 |---------------------------------------------------------------------
 * */
Route::post('/login', 'AdminController@loginUser')->before('csrf');
/*
 |---------------------------------------------------------------------
 |Route to adminController to query the children items of selected item
 |---------------------------------------------------------------------
 * */
Route::post('/org/{node}', 'AdminController@queryOrg');
/*
 |---------------------------------------------------------------------
 |Route to adminController to get the children items of selected item
 |---------------------------------------------------------------------
 * */
Route::post('/usr/{user}/section/org/{node}', 'AdminController@queryOrg');

/*
 |---------------------------------------------------------------------
 |Route to the adminController to check email exists or not
 |---------------------------------------------------------------------
 * */
Route::post('/email', 'AdminController@emailExists');
/*
 |---------------------------------------------------------------------
 |Route to the adminController to check email exists and password
 |valid or not
 |---------------------------------------------------------------------
 * */
Route::get('/tips/{msg}', function($msg) {
    $view = View::make('admin.tips');
    $view->msg = $msg;
    return $view;
});
/*
 |---------------------------------------------------------------------
 |Route to log out the current user
 |---------------------------------------------------------------------
 * */
Route::get('/logout', function() {
    if(!Auth::check()) {
        return Rediret::to('/tips/'.'您已经退出...');
    }
    else {
        Auth::logout();
        return Redirect::to('/');
    }
});
/*
 |---------------------------------------------------------------------
 |Route to user page
 |---------------------------------------------------------------------
 * */
Route::get('/user/{type}/{name}/{id}/section/{section}', 'AdminController@getUserInfo')->before('guest');
Route::get('/user/{type}/{name}/{id}/section', function($type, $name, $id) {
    if(Auth::check()){
        return View::make('home.user')->nest('childView', 'home.chart');
    }
    else {
        return Redirect::to('/tips/'.'您还未登录...');
    }
})->before('guest');
/*
 |----------------------------------------------------------------------
 |Route to admin manage page
 |----------------------------------------------------------------------
 * */
Route::get('/admin/{type}/{name}/{id}/section/{section}', 'AdminController@getUserInfo')->before('admin');
Route::get('/admin/{type}/{name}/{id}/section', function($type, $name, $id) {
    if(Auth::check()){
        return View::make('home.manage');
    }
    else {
        return Redirect::to('/tips/'.'您还未登录...');
    }
})->before('admin');
/*
 |----------------------------------------------------------------------
 |Route to modify the user info
 |----------------------------------------------------------------------
 * */
Route::post('/edit/user/{id}', 'AdminController@editUserInfo')->before(array('csrf'));
/*
 |----------------------------------------------------------------------
 |Route to denote question page
 |----------------------------------------------------------------------
 * */
Route::get('/user/action/{action}', function($action) {
    return View::make('home.user')->nest('childView', 'home.'.$action);
})->before('guest');
Route::post('/user/action/{action}/{param?}', 'AdminController@denoteQuestion')->before('guest');
Route::post('/user/{action}', 'HomeController@stastic');
/*
 |----------------------------------------------------------------------
 |Route to display the denote questions' status
 |----------------------------------------------------------------------
 * */
Route::get('/user/denote/{status}', 'AdminController@showDenote')->before('guest');
/*
 |----------------------------------------------------------------------
 |Route to questions manage page
 |----------------------------------------------------------------------
 * */
Route::get('/admin/{id}/question/{action}/{page?}/', 'AdminController@questionManagePage')->before('admin');
Route::post('/admin/{id}/question/{action}/{page?}/', 'AdminController@questionManagePage')->before('admin');
/*
 |----------------------------------------------------------------------
 |Route to AdminController to insert the question info
 |----------------------------------------------------------------------
 * */
Route::post('/admin/question/{action}/{param?}', 'AdminController@questionManage')->before(array('csrf', 'admin'));
/*
 |----------------------------------------------------------------------
 |Route to AdminController to paginate the question info
 |----------------------------------------------------------------------
 * */
Route::get('/admin/{id}/question/edit', function() {
    echo Input::get('page');
})->before('admin');
/*
 |----------------------------------------------------------------------
 |Route to AdminController to insert the info of organization and course
 |----------------------------------------------------------------------
 * */
Route::get('/admin/action/{action}',function($action) {
    return View::make('home.manage')
        ->nest('childView', 'manage.'.$action);
})->before('admin');
Route::post('/admin/action/{action}', 'AdminController@infoInsert')->before('admin');

/*
 |----------------------------------------------------------------------
 |Route to show the question select page
 |----------------------------------------------------------------------
 * */
Route::get('/user/test/{type}', function($type) {
    switch($type) {
        case 'standard':
            return View::make('home.user')
                ->nest('childView', 'manage.standardQuestion');
        case 'diy':
            return View::make('home.user')
                ->nest('childView', 'manage.diyQuestion');
        }
})->before('guest');
/*
 |----------------------------------------------------------------------
 |Route to HomeCOntroller to show the selected question page
 |----------------------------------------------------------------------
 * */
Route::post('/user/test/{type}', 'HomeController@questionSelected')->before(array('csrf', 'guest'));




