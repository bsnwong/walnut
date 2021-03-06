<?php
/**
 * Created by PhpStorm.
 * User: bsn
 * Date: 14-5-2
 * Time: 下午9:43
 */
class AdminController extends BaseController {
    //judge the user
    public function checkUser() {
        if(Session::get('user')) {
            Redirect::to('/user/'.Session::get('user'));
        }
        else {
            $view = View::make('admin.login');
            return $view;
//            return Redirect::to('login/'.);
        }
    }
    /*
     |---------------------------------------------------------------------
     |Log user in
     |---------------------------------------------------------------------
     * */
    public function loginUser() {
        $email = Input::get('email');
        $password = Input::get('password');
        $type = Input::get('type');
        $user = array(
            'email' => $email,
            'password' => $password,
            'type' => $type
        );
        if(Auth::attempt($user)) {
            if(Auth::check()) {
                View::share('email', $email);
            }
            if($type == 0) {

                return Redirect::to('/admin/0/'.Auth::user()->name.'/'.Auth::user()->id.'/section');
            }
            else {
                return Redirect::to('/user/1/'.Auth::user()->name.'/'.Auth::user()->id.'/section');
            }
        }
        else {
            return Redirect::to('/tips/'.'用户名或密码输入错误...');
        }
    }


    /*
     |---------------------------------------------------------------------
     |query the organization info
     |---------------------------------------------------------------------
     * */
    public function queryOrg($p_node) {
        $result = DB::table('Organization')
            ->where('parent_node', '=', $p_node)
            ->select('name', 'id')
            ->distinct()
            ->get();
        return json_encode(array('success' => true, 'result' => $result));
    }
    /*
     |---------------------------------------------------------------------
     |register user
     |---------------------------------------------------------------------
     * */
    public function register() {
        $count = User::emailExists(Input::get('email'))->count();
        $success = false;
        if($count) {
            Walnut::json_encode_end(array('success' => false, 'message' => '邮箱已经被注册...'));
        }
        else {
            DB::transaction(function() use(&$success) {
                $user = new User;
                $user->name = Input::get('name');
                $user->sex = Input::get('sexual');
                $user->email = Input::get('email');
                $user->password = Hash::make(Input::get('password2'));
                $user->school = Input::get('school');
                $user->college = Input::get('college');
                $user->major = Input::get('major');
                $user->school_num = Input::get('school_num');
                //create the directory of the uploaded photo
                $flag = Walnut::imageUpload('one_inch', $user);
                if($flag === true) {
                    $success = $user->save();
                }
            });
            if($success) {
                return Redirect::to('/tips/'.'恭喜你，注册成功...');
            }
            else{
                return Redirect::to('/tips/'.'很遗憾，注册失败...');
            }
        }
    }
    /*
     |---------------------------------------------------------------------
     |return the file name
     |---------------------------------------------------------------------
     * */
    public function fileName() {
    }
    /*
     |---------------------------------------------------------------------
     |Test email exists or not
     |---------------------------------------------------------------------
     * */
    public function emailExists() {
        $email = Input::get('email');
        $count = User::emailExists($email)->count();
        if($count) {
            return json_encode(array('success' => false, 'message' =>'该邮箱已被注册...' ));
        }
        else {
            return json_encode(array('success' => true, 'message' =>'邮箱可用...' ));
        }
    }
    /*
     |---------------------------------------------------------------------
     |Get user info
     |---------------------------------------------------------------------
     * */
    public function getUserInfo($type, $name, $id , $section) {
        $results = array();
        if(Auth::check()) {
            if($section) {
                switch($section) {
                    case 'private' :
                        $school = DB::table('Organization')
                            ->where('id', '=', Auth::user()->school)
                            ->select('name')
                            ->first();
                        $college = DB::table('Organization')
                            ->where('id', '=', Auth::user()->college)
                            ->first();
                        $major = DB::table('Organization')
                            ->where('id', '=', Auth::user()->major)
                            ->first();
                        $results = array(
                            'school' => $school->name,
                            'college' => $college->name,
                            'major' => $major->name
                        );
                        break;
                    case 'edit' :

                        break;
                }
                $section = '.'.$section;
                if($type == 0) {
                    return View::make('home.manage')
                        ->nest('childView', 'home'.$section, array(
                            'section' => $section,
                            'results' => $results));
                }
                elseif($type == 1) {
                    return View::make('home.user')
                        ->nest('childView', 'home'.$section, array(
                            'section' => $section,
                            'results' => $results));
                }
                else {
                    return Redirect::to('/tips/'.'用户类型不合法...');
                }
            }
        }
        else {
            return Redirect::to('/tips/'.'您还未登录...');
        }
    }
    /*
     |----------------------------------------------------------------------
     |Edit user info
     |----------------------------------------------------------------------
     * */
    public function editUserInfo($id) {
        $success = false;
        if(Auth::check()) {
            DB::transaction(function() use($id, &$success) {
                $user = array(
                    'id' => $id,
                    'password' => Input::get('password_old')
                );
                if(Auth::attempt($user)) {
                    $user = User::find($id);
                    $user->name = Input::get('name');
                    $user->sex = Input::get('sexual');
                    $user->password = Hash::make(Input::get('password2'));
                    $user->school = Input::get('school');
                    $user->college = Input::get('college');
                    $user->major = Input::get('major');
                    $user->school_num = Input::get('school_num');
                    //create the directory of the uploaded photo
                    $flag = Walnut::imageUpload('one_inch', $user);
                    if($flag === true) {
                        $success = $user->update();
                    }
                }
            });
            if($success) {
                return Redirect::to('/tips/'.'修改成功...');
            }
            else {
                return Redirect::to('/tips/'.'修改失败...');
            }
        }
        else {
            return Redirect::to('/tips/'.'您还未登录...');
        }
    }
    /*
     |----------------------------------------------------------------------
     |Show the manage questions page
     |----------------------------------------------------------------------
     * */
    public function questionManagePage($id, $action, $param=1) {
        switch($action) {
            case 'insert' :
            case 'audit' :
            case 'modify' :
            case 'edit' :
            case 'search':
                $page = $param;
                $data = null;
                $perPage = 10;
                if($action === 'edit' || $action === 'audit' ) {
                    if($action === 'edit') {
                        $data = Question::where('author', '=', Auth::user()->email)
                            ->forPage($page, $perPage)
                            ->get();
                        $total = Question::where('author', '=', Auth::user()
                            ->email)
                            ->count();
                    }
                    elseif($action === 'audit') {
                        $data = Question::where('allow', '=', 0)
                            ->forPage($page, $perPage)
                            ->get();
                        $total = Question::where('allow', '=', 0)
                            ->count();
                    }
                    $page = $total%$perPage ? (int)($total/$perPage+1) : $total/$perPage;
                }
                if($action === 'search') {
                    $word = Input::get('word') ? Input::get('word') : Session::get('word');
                    $question_type = Input::get('question_type') ? Input::get('question_type') : 0;
                    $search_type = Input::get('search_type');
                    $from = Input::get('from');
                    Session::set('word', $word);
                    if($search_type == '1') {
                        $search_type = 'id';
                    }
                    elseif($search_type == '2') {
                        $search_type = 'question';
                    }
                    else {
                        $search_type = Session::get('search_type');
                    }
                    Session::set('search_type', $search_type);
                    if($action === 'search' && $from !== 'audit') {
                        if($question_type === 0) {
                            $data = Question::where($search_type, 'LIKE', '%'.$word.'%')
                                ->forPage($page, $perPage)
                                ->get();
                            $total = Question::where($search_type, 'LIKE', '%'.$word.'%')
                                ->count();
                        }
                        elseif($question_type === '8') {
                            $question_type = 0;
                            $data = Question::where($search_type, 'LIKE', '%'.$word.'%')
                                ->where('type', '=', $question_type)
                                ->forPage($page, $perPage)
                                ->get();
                            $total = Question::where($search_type, 'LIKE', '%'.$word.'%')
                                ->where('type', '=', $question_type)
                                ->count();
                        }
                        else {
                            $data = Question::where($search_type, 'LIKE', '%'.$word.'%')
                                ->where('type', '=', $question_type)
                                ->forPage($page, $perPage)
                                ->get();
                            $total = Question::where($search_type, 'LIKE', '%'.$word.'%')
                                ->where('type', '=', $question_type)
                                ->count();
                        }

                    }
                    elseif($from === 'audit') {
                        if($question_type === 0) {
                            $data = Question::where($search_type, 'LIKE', '%'.$word.'%')
                                ->where('allow', '=', 0)
                                ->forPage($page, $perPage)
                                ->get();
                            $total = Question::where($search_type, 'LIKE', '%'.$word.'%')
                                ->where('allow', '=', 0)
                                ->count();
                        }
                        elseif($question_type === '8') {
                            $question_type = 0;
                            $data = Question::where($search_type, 'LIKE', '%'.$word.'%')
                                ->where('type', '=', $question_type)
                                ->where('allow', '=', 0)
                                ->forPage($page, $perPage)
                                ->get();
                            $total = Question::where($search_type, 'LIKE', '%'.$word.'%')
                                ->where('type', '=', $question_type)
                                ->where('allow', '=', 0)
                                ->count();
                        }
                        else {
                            $data = Question::where($search_type, 'LIKE', '%'.$word.'%')
                                ->where('type', '=', $question_type)
                                ->where('allow', '=', 0)
                                ->forPage($page, $perPage)
                                ->get();
                            $total = Question::where($search_type, 'LIKE', '%'.$word.'%')
                                ->where('type', '=', $question_type)
                                ->where('allow', '=', 0)
                                ->count();
                        }
                    }
                    $page = $total%$perPage ? (int)($total/$perPage+1) : $total/$perPage;
                    $action = 'edit';
                }
                if($action === 'modify') {
                    $id = $param;
                    $data = Question::find($id);
                }
                return View::make('home.manage')
                    ->nest(
                        'childView',
                        'manage.question'.ucfirst($action),
                        array(
                            'data' => $data,
                            'page' => $page
                        )
                    );
            case 'delete':
                $params = array('u_email' => Auth::user()->email, 'q_id' => $param);
                DB::transaction(function() use($params){
                    $del_id = Question::where('author', '=', $params['u_email'])
                        ->where('id', '=', $params['q_id'])
                        ->delete();
                    if($del_id) {
                        echo json_encode(array('success' => true, 'message' =>'删除成功...'));
                    }
                    else {
                        echo json_encode(array('success' => false, 'message' =>'删除失败...'));
                    }
                });
                break;
            case 'pass':
                $params = array('u_email' => Auth::user()->email, 'q_id' => $param);
                DB::transaction(function() use($params){
                    $pass_id = Question::find($params['q_id']);
                    $pass_id->allow = 1;
                    $pass = $pass_id->update();
                    if($pass) {
                        echo json_encode(array('success' => true, 'message' =>'审核通过...'));
                    }
                    else {
                        echo json_encode(array('success' => false, 'message' =>'操作失败...'));
                    }
                });
                break;
            case 'read' :
                $page = $param;
                $perPage = 20;
                $users = User::select(DB::raw('DISTINCT email, id'))
                    ->where('school', '=', Auth::user()->school)
                    ->where('college', '=', Auth::user()->college)
                    ->where('major', '=', Auth::user()->major)
                    ->get();
                $results = array();
                $total = 0;
                foreach($users as $index => $user) {
                    $user_id = $user->id;
                    $result = User::find($user_id)
                        ->result()
                        ->where('read', '=', 0)
                        ->whereNotIn('q_type', array('1', '2', '3', '4'), 'and')
                        ->get();
                   $count = User::find($user_id)
                        ->result()
                        ->where('read', '=', 0)
                        ->whereNotIn('q_type', array('1', '2', '3', '4'), 'and')
                        ->count();
                    $total += $count;
                    foreach($result as $k => $v) {
                        $question = Result::find($v->id)
                            ->question()
                            ->first();
                        $results[$user_id][$v->nth][] = array(
                            'question' => $question,
                            'result' => $v
                        );
                    }
                }
                return View::make('home.manage')
                    ->nest(
                        'childView',
                        'home.read',
                        array(
                            'data' => $results,
                            'total' => $total,
                            'perpage' => 20
                        )
                    );
                break;
            case 'postScore':
                $score = Input::get('score');
                $result2 = Input::get('result');
                $success = false;
                DB::transaction(function() use($score, $result2, &$success){
                    foreach($score as $index => $value) {
                        if($value >= 0) {
                            $r = Result::find($result2[$index]);
                            $r->score = $value;
                            $r->read = 1;
                            $success = $r->update();
                        }
                    }
                });
                if($success) {
                    return Redirect::to('/tips/'.'评分成功...');
                }
                else {
                    return Redirect::to('/tips/'.'评分失败...');
                }
            default:
                return Redirect::to('/tips/'.'您的请求不合法...');
        }
    }
    /*
     |----------------------------------------------------------------------
     |Read the result and post the score
     |----------------------------------------------------------------------
     * */
    public static function postScore() {

    }
    /*
     |-----------------------------------------------------------------------
     |Manage the question info, including insert, update, query, and delete
     |-----------------------------------------------------------------------
     * */
    public function questionManage($action, $param = null) {
        //get the info from the question insert page
        if($action == 'insert') {
            $question = new Question;
        }
        elseif($action == 'modify') {
            $q_id = $param;
            $question = Question::find($q_id);
        }
        $question->c_id = Input::get('course');
        $question->type = Input::get('question_type');
        $question->question = Input::get('question');
        if(Input::get('question_type') == '1') {
            $question->answer_num = Input::get('amount');
            $question->select_options = Input::get('select_options');
        }
        else {
            $question->answer_num = Input::get('ms_amount');
            $question->select_options = Input::get('m_select_options');
        }
        $question->analysis = Input::get('answer_analysis');
        $question->score = Input::get('score');
        $question->level = Input::get('question_level');
        $question->time_limit = Input::get('time_limit');
        $question->author = Auth::user()->email;
        $question->allow = 1;
        //set the default value for the answer
        switch(Input::get('question_type')) {
            case '1' ://single selection question
                $question->answer2 = Input::get('answer1');
                break;
            case '2' ://multiple selection question
                $question->answer4 = implode('|', Input::get('selected_answer'));
                break;
            case '3' ://blank
                $answer5 = explode('|', Input::get('blank_type'));
                $new_answer5 = array();
                foreach($answer5 as $item) {
                    $new_answer5[] = trim($item);
                }
                $question->answer5 = implode('|', $new_answer5);
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
            if($action == 'insert') {
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
        $question->c_id = Input::get('course');
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
    /*
     |-----------------------------------------------------------------------
     |Show the denoted question of current user
     |-----------------------------------------------------------------------
     * */
    public function showDenote($status) {
        switch($status) {
            case 'pass' :
            case 'wait' :
                if($status === 'pass') {
                    $data = Question::where('author', '=', Auth::user()->email)
                        ->where('allow', '=', '1')
                        ->get();
                }
                if($status === 'wait') {
                    $data = Question::where('author', '=', Auth::user()->email)
                        ->where('allow', '=', '0')
                        ->get();
                }
                return View::make('home.user')
                    ->nest('childView', 'home.'.$status, array('data' => $data));
            default :
                return Redirect::to('/tips/'.'您的请求不合法...');
        }
    }
    /*
     |-----------------------------------------------------------------------
     |Insert info of org and course into database
     |-----------------------------------------------------------------------
     */
    public function infoInsert($action) {
        switch($action) {
            case 'orginsert':
                $org = new Organization;
                $org_type = Input::get('org');
                switch($org_type) {
                    case '0':
                        $org->name = Input::get('school_insert');
                        $org->parent_node = 0;
                        break;
                    case '1' :
                        $school = Input::get('school_options');
                        $org->name = Input::get('college_insert');
                        $org->parent_node = $school;
                        break;
                    case '2':
                        $collge = Input::get('college_options');
                        $org->name = Input::get('major_insert');
                        $org->parent_node = $collge;
                        break;
                }
                $success = $org->save();
                if($success) {
                    return Redirect::to('/tips/'.'信息已经录入...');
                }
                else {
                    return Redirect::to('/tips/'.'信息录入失败...');
                }
                break;
            case 'courseinsert' :
                $success = false;
                DB::transaction(function() use(&$success){
                    $course = new Course;
                    $course->name = Input::get('course');
                    $course->creator = Auth::user()->email;
                    $success = $course->save();
                });
                if($success) {
                    return Redirect::to('/tips/'.'信息录入成功...');
                }
                else {
                    return Redirect::to('/tips/'.'信息录入失败...');
                }
                break;
        }
    }
}