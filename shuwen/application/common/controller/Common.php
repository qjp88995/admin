<?php
namespace app\common\controller;

use think\Controller;

class Common extends Controller{
    protected function _initialize(){

    }
    public function _empty(){
        return $this->fetch(config('error_page.404'));
    }
}