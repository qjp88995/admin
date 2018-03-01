<?php
namespace app\admin\controller;

use think\Controller;

class Index extends Controller{
    function index(){
        return $this->fetch();
    }
}