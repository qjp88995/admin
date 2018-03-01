<?php
namespace app\login\controller;

use app\common\controller\Common;
use app\common\model\Admin;

class Index extends Common{
    public function login(){
        $Admin = new Admin;
        $userinfo = $Admin->login(request()->only('username,password'));
        if(!empty($userinfo)){
            session('user',$userinfo);
            session('user.admin',1);
            return json([
                'code'=> 200,
                'msg' => '登录成功'
            ]);
        }else{
            return json([
                'code'=> 500,
                'msg' => '账号密码不正确'
            ]);
        }
    }
    public function loginout(){
        session(null);
        return json([
            'code'=> 200,
            'msg' => '退出成功'
        ]);
    }
}