<?php
namespace app\model;

use think\Model;

class Admin extends Model{
    public function login($data){
        $result = $this->where('password',md5($data['password']))->where('username',$data['username'])->find();
        if(!empty($result)){
            return $result;
        }else{
            return false;
        }
    }
}