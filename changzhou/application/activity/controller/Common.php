<?php
namespace app\activity\controller;

use think\Controller;
use think\Session;
use app\model\service\Wechat;
class Common extends Controller{
    protected $beforeActionList = [
        'isLogin'
    ];
    protected function isLogin(){
        if(!Session::has('_id','wechat')){
            abort(401);
        }
    }
}