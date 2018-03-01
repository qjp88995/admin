<?php
namespace app\index\controller;

use app\common\controller\Auth;

class User extends Auth{
    public function index(){
        return $this->fetch();
    }
}