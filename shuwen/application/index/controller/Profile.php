<?php
namespace app\index\controller;

use think\Controller;
use app\model\Profile as Pro;

class Profile extends Controller{
    public function index(){
        $intro = Pro::where(['name'=>'intro'])->find();
        $organization = Pro::where(['name'=>'organization'])->find();
        $information = Pro::where(['name'=>'information'])->find();
        $contact = Pro::where(['name'=>'contact'])->find();
        $events = Pro::where(['name'=>'events'])->order('year','desc')->select();
        $question = Pro::where(['name'=>'question'])->find();
        $this->assign([
            'intro'        => $intro,
            'organization' => $organization,
            'information'  => $information,
            'contact'      => $contact,
            'events'       => $events,
            'question'     => $question
        ]);
        return $this->fetch();
    }
    public function events(){
        if(request()->isPost()){
            $events = Pro::where(['name'=>'events'])->field('content',true)->order('year','desc')->select();
            foreach ($events as $key => $value) {
                $events[$key] = [
                    '_id' => $value->_id,
                    'year' => $value->year
                ];
            }
            return json($events);
        }else{
            $id = request()->route('id');
            $detail = Pro::find($id);
            $this->assign('detail', $detail);
            return $this->fetch('detail');
        }
    }
}