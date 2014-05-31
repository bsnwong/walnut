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
        if(Auth::check()) {
            if(Auth::user()->type == 1) {
                $view = View::make('home.user');
            }
            elseif( Auth::user()->type == 0) {
                $view = View::make('home.manage');
            }
            return $view;
        }
        else {
            return Redirect::to('/tips/'.'您还未登录...');
        }
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
                    ->where('level', '=', Input::get('question_level'))
                    ->where('c_id', '=', Input::get('course'))
                    ->orderBy(DB::raw('RAND()'))
                    ->limit(5)
                    ->get();
                $ms_select = Question::where('type', '=', 2)
                    ->where('allow', '=', 1)
                    ->where('level', '=', Input::get('question_level'))
                    ->where('c_id', '=', Input::get('course'))
                    ->orderBy(DB::raw('RAND()'))
                    ->limit(5)
                    ->get();
                $blank = Question::where('type', '=', 3)
                    ->where('allow', '=', 1)
                    ->where('level', '=', Input::get('question_level'))
                    ->where('c_id', '=', Input::get('course'))
                    ->orderBy(DB::raw('RAND()'))
                    ->limit(5)
                    ->get();
                $judge = Question::where('type', '=', 4)
                    ->where('allow', '=', 1)
                    ->where('level', '=', Input::get('question_level'))
                    ->where('c_id', '=', Input::get('course'))
                    ->orderBy(DB::raw('RAND()'))
                    ->limit(5)
                    ->get();
                $qanda = Question::where('type', '=', 5)
                    ->where('allow', '=', 1)
                    ->where('level', '=', Input::get('question_level'))
                    ->where('c_id', '=', Input::get('course'))
                    ->orderBy(DB::raw('RAND()'))
                    ->limit(2)
                    ->get();
                $calculate = Question::where('type', '=', 6)
                    ->where('allow', '=', 1)
                    ->where('level', '=', Input::get('question_level'))
                    ->where('c_id', '=', Input::get('course'))
                    ->orderBy(DB::raw('RAND()'))
                    ->limit(2)
                    ->get();
                $comprehensive = Question::where('type', '=', 7)
                    ->where('allow', '=', 1)
                    ->where('level', '=', Input::get('question_level'))
                    ->where('c_id', '=', Input::get('course'))
                    ->orderBy(DB::raw('RAND()'))
                    ->limit(1)
                    ->get();
                $other = Question::where('type', '=', 0)
                    ->where('allow', '=', 1)
                    ->where('level', '=', Input::get('question_level'))
                    ->where('c_id', '=', Input::get('course'))
                    ->orderBy(DB::raw('RAND()'))
                    ->limit(1)
                    ->get();
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
                    ->nest(
                        'childView',
                        'manage.standardQuestion',
                        array(
                            'data' => $data,
                            'c_id' => Input::get('course')
                        )
                    );
            case 'post':
                //single select
                $select = Input::get('select') ? Input::get('select') : array();
                $select_result = array();
                foreach($select as $k => $v) {
                    $s_option = Input::get('select'.$k);
                    $select_result[] = array('q_id' => $v, 'q_type' => 1, 'answer' => $s_option);
                }
                //multi select
                $ms_select = Input::get('ms_select') ? Input::get('ms_select') : array();
                $ms_select_result = array();
                foreach($ms_select as $k => $v) {
                    $ms_option = implode('|', Input::get('ms_select'.$k));
                    $ms_select_result[] = array('q_id' => $v, 'q_type' => 2, 'answer' => $ms_option);
                }
                //blank
                $blank = Input::get('blank') ? Input::get('blank') : array();
                $blank_result = array();
                foreach($blank as $k => $v) {
                    $blank_answer = trim(Input::get('blank_answer'.$k));
                    $blank_result[] = array('q_id' => $v, 'q_type' => 3, 'answer' => $blank_answer);
                }
                //judge
                $judge = Input::get('judge') ? Input::get('judge') : array();
                $judge_result = array();
                foreach($judge as $k => $v) {
                    $judge_type = Input::get('judge_type'.$k);
                    $judge_result[] = array('q_id' => $v, 'q_type' => 4,  'answer' => $judge_type);
                }
                //question and answer
                $qanda = Input::get('qanda') ? Input::get('qanda') : array();
                $qanda_result = array();
                foreach($qanda as $k => $v) {
                    $qanda_answer = Input::get('qanda_answer'.$k);
                    $qanda_result[] = array('q_id' => $v, 'q_type' => 5, 'answer' => $qanda_answer);
                }
                //calculate
                $calculate = Input::get('calculate') ? Input::get('calculate') : array();
                $calculate_result = array();
                foreach($calculate as $k => $v) {
                    $calculate_answer = Input::get('calculate_answer'.$k);
                    $calculate_result[] = array('q_id' => $v, 'q_type' => 6, 'answer' => $calculate_answer);
                }
                //comprehensive
                $comprehensive = Input::get('comprehensive') ? Input::get('comprehensive') : array();
                $comprehensive_result = array();
                foreach($comprehensive as $k => $v) {
                    $comprehensive_answer = Input::get('comprehensive_answer'.$k);
                    $calculate_result[] = array('q_id' => $v, 'q_type' => 7, 'answer' => $comprehensive_answer);
                }
                //other
                $other = Input::get('other') ? Input::get('other') : array();
                $other_result = array();
                foreach($other as $k => $v) {
                    $other_answer = Input::get('other_answer'.$k);
                    $other_result[] = array('q_id' => $v, 'q_type' => 0, 'answer' => $other_answer);
                }
                $result = array(
                    'select' => $select_result,
                    'ms_select' => $ms_select_result,
                    'blank' => $blank_result,
                    'judge' => $judge_result,
                    'qanda' => $qanda_result,
                    'calculate' => $calculate_result,
                    'comprehensive' => $comprehensive_result,
                    'other' => $other_result,
                );
                //insert the result to database
                DB::transaction(function() use($result) {
                    $nth = DB::table('Result')
                        ->where('c_id', '=', Input::get('c_id'))
                        ->where('u_email', '=', Auth::user()->email)
                        ->max('nth');
                    $nth = !empty($nth) ? ++$nth : 1;
                    foreach($result as $index => $value) {
                        foreach($value as $k => $v) {
                            $r = new Result;
                            $r->q_id = $v['q_id'];
                            $r->q_type = $v['q_type'];
                            $r->answer = $v['answer'] ? $v['answer'] : '';
                            $r->c_id = Input::get('c_id');
                            $r->u_email = Auth::user()->email;
                            $r->nth = $nth;
                            if(in_array($v['q_type'], array('1', '2', '3', '4'))) {
                                $answer = explode('|', $v['answer']);
                                $new_answer = array();
                                foreach($answer as $k1 => $v1) {
                                    $new_answer[] = trim($v1);
                                }
                                $r->answer = implode('|', $new_answer);
                                $question = Question::find($v['q_id']);
                                switch($question->type) {
                                    case '1' :
                                        $compare = 'answer2';
                                        break;
                                    case '2' :
                                        $compare = 'answer4';
                                        break;
                                    case '3' :
                                        $compare = 'answer5';
                                        break;
                                    case '4' :
                                        $compare = 'answer3';
                                        break;
                                    default:
                                        break;
                                }
                                if($r->answer == $question->$compare) {
                                    $r->score = $question->score;
                                }
                                $r->read = 1;
                            }
                            $r->save();
                        }
                    }
                });
                return Redirect::to('/tips/'.'题目已经提交，请耐心等候测试结果...');
        }
    }

    /*
     |----------------------------------------------------------------------
     |Show the user's request page
     |----------------------------------------------------------------------
     * */
    public function stastic($action) {
        $result = null;
        switch($action) {
            case 'chart':
                $data = Result::select(array(DB::raw('SUM(score) as total'), 'nth'))
                    ->where('u_email', '=', Auth::user()->email)
                    ->where('read', '=', 1)
                    ->where('c_id', '=', Input::get('c_id'))
                    ->groupBy('nth')
                    ->get();
                $score = array();
                foreach($data as $item) {
                    $score[] = (int)$item->total;
                }
                $result = array(
                    'chart' => array(
                        'renderTo' => 'chart',
                        'type' => 'spline'
                    ),
                    'title' => array(
                        'text' => '个人测试情况'
                    ),
                    'xAxis' => array(
                        'title' => array(
                            'text' => '测试次数'
                        ),
                        'tickInterval' => 1
                    ),
                    'yAxis' => array(
                        'title' => array(
                            'text' => '分数'
                        ),
                        'tickInterval' => 2
                    ),
                    'series' => array(
                        array(
                            'name' => Auth::user()->name,
                            'data' => $score,
                        ),
                    )
                );
                return json_encode($result);
            case 'allchart' :
                $data = Result::select(array(DB::raw('SUM(score) as total'), 'nth'))
                    ->where('read', '=', 1)
                    ->where('c_id', '=', Input::get('c_id'))
                    ->groupBy('nth')
                    ->get();
                $score = array();
                foreach($data as $item) {
                    $count = Result::select(DB::raw('DISTINCT u_email'))->where('read', '=', 1)
                        ->where('c_id', '=', Input::get('c_id'))
                        ->where('nth', '=', $item->nth)
                        ->get();
                    $count = count($count);
                    $score[] = (float)($item->total/$count);
                }
                $result = array(
                    'chart' => array(
                        'renderTo' => 'chart',
                        'type' => 'spline'
                    ),
                    'title' => array(
                        'text' => '总体测试情况'
                    ),
                    'xAxis' => array(
                        'title' => array(
                            'text' => '测试次数'
                        ),
                        'tickInterval' => 1
                    ),
                    'yAxis' => array(
                        'title' => array(
                            'text' => '分数'
                        ),
                        'tickInterval' => 2
                    ),
                    'series' => array(
                        array(
                            'name' => '总体平均分',
                            'data' => $score,
                        ),
                    )
                );
                return json_encode($result);

                break;
            case 'compare' :
                $data = Result::select(array(DB::raw('SUM(score) as total'), 'nth'))
                    ->where('u_email', '=', Auth::user()->email)
                    ->where('read', '=', 1)
                    ->where('c_id', '=', Input::get('c_id'))
                    ->groupBy('nth')
                    ->get();
                $score = array();
                foreach($data as $item) {
                    $score[] = (int)$item->total;
                }
                $alldata = Result::select(array(DB::raw('SUM(score) as total'), 'nth'))
                    ->where('read', '=', 1)
                    ->where('c_id', '=', Input::get('c_id'))
                    ->groupBy('nth')
                    ->get();
                $allscore = array();
                foreach($alldata as $allitem) {
                    $allcount = Result::select(DB::raw('DISTINCT u_email'))->where('read', '=', 1)
                        ->where('c_id', '=', Input::get('c_id'))
                        ->where('nth', '=', $allitem->nth)
                        ->get();
                    $allcount = count($allcount);
                    $allscore[] = (float)($allitem->total/$allcount);
                }
                $result = array(
                    'chart' => array(
                        'renderTo' => 'chart',
                        'type' => 'spline'
                    ),
                    'title' => array(
                        'text' => '对比'
                    ),
                    'xAxis' => array(
                        'title' => array(
                            'text' => '测试次数'
                        ),
                        'tickInterval' => 1
                    ),
                    'yAxis' => array(
                        'title' => array(
                            'text' => '分数'
                        ),
                        'tickInterval' => 2
                    ),
                    'series' => array(
                        array(
                            'name' => Auth::user()->name,
                            'data' => $score,
                        ),
                        array(
                            'name' => '总体平均分',
                            'data' => $allscore,
                        ),
                    )
                );
                return json_encode($result);

        }
    }
    /*
     |-----------------------------------------------------------------------
     |Normal user denote question to database
     |-----------------------------------------------------------------------
     */
    public function denoteQuestion($action, $param = null) {
        //get the info from the question insert page
        if($action == 'denote') {
            $question = new Question;
        }
        elseif($action == 'modify') {
            $q_id = $param;
            $question = Question::find($q_id);
        }
        $question->course_code = Input::get('course');
        $question->type = Input::get('question_type');
        $question->question = Input::get('question');
        if(Input::get('question_type') == '1') {
            $question->answer_num = Input::get('amount');
        }
        else {
            $question->answer_num = Input::get('ms_amount');
        }
        $question->select_options = Input::get('select_options');
        $question->analysis = Input::get('answer_analysis');
        $question->score = Input::get('score');
        $question->level = Input::get('question_level');
        $question->time_limit = Input::get('time_limit');
        $question->author = Auth::user()->email;
        $question->allow = 0;
        //set the default value for the answer
        switch(Input::get('question_type')) {
            case '1' ://single selection question
                $question->answer2 = Input::get('answer1');
                break;
            case '2' ://multiple selection question
                $question->answer4 = implode('|', Input::get('selected_answer'));
                break;
            case '3' :
                $question->answer5 = Input::get('blank_type');
                break;
            case '4' ://judge question
                $question->answer3 = Input::get('judge_type');
                break;
            default :
                $question->answer = Input::get('other_type');
        }
        $success = false;
        $msg = '操作成功...';
        DB::transaction(function() use($question, &$success, $action, &$msg) {
            if($action == 'denote') {
                $success = $question->save();
                $msg = '试题已经录入...';
            }
            elseif($action == 'modify') {
                $success = $question->update();
                $msg = '试题已更新...';
            }
        });
        if($success) {
            return Redirect::to('/tips/'.$msg);
        }
        else {
            return Redirect::to('/tips/'.'很抱歉，试题录入失败...');
        }
    }
}