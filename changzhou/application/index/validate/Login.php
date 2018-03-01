<?php
namespace app\index\validate;

use think\Validate;

class Login extends Validate{
    protected function _initialize(){

    }
    protected $rule = [
        'username' => 'require|token',
        'password' => 'require'
    ];
    protected $message = [
        'username.require' => '账号不能为空',
        'username.token'   => '表单信息已过期！',
        'password'         => '密码不能为空'
    ];
}