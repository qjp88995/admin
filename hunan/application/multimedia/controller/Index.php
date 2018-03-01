<?php
namespace app\multimedia\controller;

use app\common\controller\Auth;

class Index extends Auth{
    public function index(){
        return $this->fetch();
    }
    public function file(){
        return $this->fetch();
    }
}