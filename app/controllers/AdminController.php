<?php
/**
 * Created by PhpStorm.
 * User: bsn
 * Date: 14-5-2
 * Time: 下午9:43
 */
class AdminController extends BaseController {
    //judge the user
    public function judgeUser() {
        if(Session::get('user')) {
            Redirector::to('/user/'.Session::get('user'));
        }
        else {
            //get the info from login form
            $email = Input::get('email');
            $password = Input::get('password');
            $result = DB::table('User')->where('email', '=', $email)->get();
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
                        return json_encode(array('success' => true, 'message' => '恭喜你，注册成功...'));
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

}