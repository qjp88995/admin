<?php
namespace app\admin\controller;

use app\common\controller\Auth;
use app\admin\model\User as U;

class User extends Auth{
    public function index(){
        if(request()->isAjax()){
            if(!trim(empty(request()->param('title')))){
                $where['title'] = ['like', trim(request()->param('title'))];
            }
            if(!trim(empty(request()->param('_id')))){
                return U::field('_id,username,email,tel,groups,extra_auths')->find(request()->param('_id'));
            }
            $list = U::where(@$where)->paginate();
            return $list;
        }else{
            return $this->fetch();
        }
    }

    public function insert(){
        $user = new U;
        $user->username = request()->param('username');
        $user->email = request()->param('email');
        $user->tel = request()->param('tel');
        $user->password = "";
        if(empty(request()->param()['groups'])){
            $user->groups = [];
        }else{
            $user->groups = request()->param()['groups'];
        }
        if(empty(request()->param()['extra_auths'])){
            $user->extra_auths = [];
        }else{
            $user->extra_auths = request()->param()['extra_auths'];
        }
        $user->isAdmin = 0;
        $user->activity = [
            'state'=>0,
            'code'=>md5(time())
        ];
        $user->login_number = 0;
        $user->reset = ['code'=>'','expir'=>''];
        $user->log_ip = '';
        $user->log_time = '';
        $user->user_info = [];
        $result = $user->save();
        if($result){
            return ['code'=>true, "msg"=>'添加成功！'];
        }else{
            return ['code'=>false, "msg"=>'添加失败！'];
        }
    }

    public function update(){

    }

    protected function checkUniq(){
        
    }
}