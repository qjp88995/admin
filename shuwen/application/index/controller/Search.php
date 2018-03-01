<?php
namespace app\index\controller;

use think\Controller;
use app\model\News;

class Search extends Controller{
    public function index(){
        $this->assign('title', trim(request()->param('title')));
        return $this->fetch();
    }
}