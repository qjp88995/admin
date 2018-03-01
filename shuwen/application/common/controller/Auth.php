<?php
namespace app\common\controller;

use app\common\controller\Common;
use app\index\model\Auth as AuthModel;

/**
 * 权限控制类
 * @author 秦嘉鹏
 */
class Auth extends Common{

    /**
     * 初始化函数，同时会执行父类的构造函数
     */
    protected function _initialize(){

    }

    /**
     * 前置方法，在执行每个方法之前都会执行的函数
     * @param function checkAuth 检查权限
     */
    protected $beforeActionList = [
        'checkAuth'
    ];

    protected function checkAuth(){
        if(session('user.admin') === 1){
            return true;
        }else{
            exit(json_encode(
                [
                    'code'=> 403,
                    'msg'  => '请先登录'
                ]
            ));
        }
    }
}