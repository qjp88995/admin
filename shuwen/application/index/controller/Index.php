<?php
namespace app\index\controller;

use think\Controller;
use app\model\Profile as Pro;
use app\model\News as NewsList;

class Index extends Controller{
    public function index(){
        $information = Pro::where(['name'=>'information'])->find();
        $contact = Pro::where(['name'=>'contact'])->find();
        $notics = NewsList::where(['category.name'=>'announcement'])->limit(0, 8)->select();
        $this->assign([
            'information' => $information,
            'contact'     => $contact,
            'notics'       => $notics
        ]);
        return $this->fetch();
    }
}