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
        return json_encode($result);
    }
    /*
     |---------------------------------------------------------------------
     |register user
     |---------------------------------------------------------------------
     * */
    public function register() {
        $user = new User;
        $user->name = Input::get('name');
        $user->sex = Input::get('sexual');
        $user->email = Input::get('email');
        $user->password = md5(Input::get('password2'));
        $user->school = Input::get('school');
        $user->college = Input::get('college');
        $user->major = Input::get('major');
        $user->school_num = Input::get('school_num');

        $count = DB::table('User')
            ->where('email', '=', $user->email)
            ->get();
        if($count) {
            echo "sad";
        }
        else {
            DB::transaction(function() use ($user) {
                $user->save();
                echo 'lucky';
            });
        }


    }
}