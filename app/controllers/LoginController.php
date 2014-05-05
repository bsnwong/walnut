<?php
/**
 * Created by PhpStorm.
 * User: bsn
 * Date: 14-5-2
 * Time: 下午9:43
 */
class LoginController extends BaseController {
    public function judgeUser() {
        //get the info from login form
        $email = Input::get('email');
        $password = Input::get('password');

        $result = DB::table('User')->where('email', '=', $email)->get();


        return "hello";
    }
}