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
    /*
     |----------------------------------------------------------------------
     |Show the selected question page
     |----------------------------------------------------------------------
     * */
    public function questionSelected($type) {
        $course = null;//科目
        $level = null;//难度
        $select = null;//选择题
        $ms_select = null;//多选题
        $blank = null;//填空题
        $judge = null;//判断题
        $qanda = null;//简答题
        $calculate = null;//计算题
        $comprehensive = null;//综合题
        $other = null;//其他
        $data = array(
            'select' => $select,
            'ms_select' => $ms_select,
            'blank' => $blank,
            'judge' => $judge,
            'qanda' => $qanda,
            'calculate' => $calculate,
            'comprehensive' => $comprehensive,
            'other' => $other,
        );
        switch($type) {
            case 'standard':
                $count = Question::count();
                if($count > 5) {
                    $offset = rand(1, $count - 5);
                }
                else {
                    $offset = 1;
                }
                $select = Question::where('type', '=', 1)
                    ->where('allow', '=', 1)
                    ->orderBy(DB::raw('RAND()'))
                    ->limit(5)
                    ->get();
                $ms_select = Question::where('type', '=', 2)
                    ->where('allow', '=', 1)
                    ->orderBy(DB::raw('RAND()'))
                    ->limit(5)
                    ->get();
                $blank = Question::where('type', '=', 3)
                    ->where('allow', '=', 1)
                    ->orderBy(DB::raw('RAND()'))
                    ->limit(5)
                    ->get();
                $judge = Question::where('type', '=', 4)
                    ->where('allow', '=', 1)
                    ->orderBy(DB::raw('RAND()'))
                    ->limit(5)
                    ->get();
                $qanda = Question::where('type', '=', 5)
                    ->where('allow', '=', 1)
                    ->orderBy(DB::raw('RAND()'))
                    ->limit(2)
                    ->get();
                $calculate = Question::where('type', '=', 6)
                    ->where('allow', '=', 1)
                    ->orderBy(DB::raw('RAND()'))
                    ->limit(2)
                    ->get();
                $comprehensive = Question::where('type', '=', 7)
                    ->where('allow', '=', 1)
                    ->orderBy(DB::raw('RAND()'))
                    ->limit(1)
                    ->get();
                $other = Question::where('type', '=', 0)
                    ->where('allow', '=', 1)
                    ->orderBy(DB::raw('RAND()'))
                    ->limit(1)
                    ->get();
                break;
            case 'diy':
                break;
        }
        $data = array(
            'select' => $select,
            'ms_select' => $ms_select,
            'blank' => $blank,
            'judge' => $judge,
            'qanda' => $qanda,
            'calculate' => $calculate,
            'comprehensive' => $comprehensive,
            'other' => $other,
        );
        return View::make('home.user')
            ->nest('childView', 'manage.standardQuestion', array('data' => $data));
    }

}