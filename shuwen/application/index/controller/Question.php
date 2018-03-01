<?php
namespace app\index\controller;

use think\Controller;
use app\model\Profile as Pro;

class Question extends Controller{
    public function index(){
        $question = Pro::where(['name'=>'question'])->find();
        $this->assign([
            'question' => $question
        ]);
        return $this->fetch();
    }
}