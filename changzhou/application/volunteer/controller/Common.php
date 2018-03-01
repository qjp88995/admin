<?php
namespace app\volunteer\controller;

use think\Controller;
use think\Session;
class Common extends Controller{
    protected $beforeActionList = [
        'isLogin' =>  ['except'=>'register,login']
    ];
    protected function isLogin(){
        if(!Session::has('_id','volunteer')){
            abort(401);
        }
    }
}