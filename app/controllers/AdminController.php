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
        if($count) {
            Walnut::json_encode_end(array('success' => false, 'message' => '邮箱已经被注册...'));
        }
        else {
            DB::transaction(function() {
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
                    if($user->save()) {
                        echo json_encode(array('success' => true, 'message' => '恭喜你，注册成功...'));
                    }
                    else {
                        Walnut::json_encode_end(array('success' => false, 'message' => '很遗憾，注册失败...'));
                    }
                }
                else {
                    Walnut::json_encode_end(array('success' => false, 'message' => '很遗憾，注册失败...'));
                }
            });
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
            return json_encode(array('success' => false, 'message' => '该邮箱已被注册...'));
        }
        else {
            return json_encode(array('success' => true, 'message' => '邮箱可用...'));
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
        if(Auth::check()) {
            DB::transaction(function() use($id) {
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
                        if($user->update()) {
                            echo json_encode(array('success' => false, 'message' => '修改成功...'));
                        }
                        else {
                            echo json_encode(array('success' => false, 'message' => '修改失败...'));
                        }
                    }
                    else {
                        echo json_encode(array('success' => false, 'message' => '修改失败...'));
                    }
                }
                else {
                    echo json_encode(array('success' => false, 'message' => '旧密码不正确...'));
                }
            });
        }
        else {
            echo  json_encode(array('success' => false, 'message' => '您还未登录...'));
        }
    }
    /*
     |----------------------------------------------------------------------
     |Manage questions
     |----------------------------------------------------------------------
     * */
    public function questionManage($id, $action) {
        switch($action) {
            case 'insert' :
            case 'audit' :
            case 'edit' :
                return View::make('home.manage')
                    ->nest('childView', 'manage/question'.ucfirst($action));
                break;
            default :
                return Redirect::to('/tips/'.'您的请求不合法...');
        }
    }
}