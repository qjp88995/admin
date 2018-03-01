<?php

namespace app\api\controller;

use think\Controller;
use app\api\model\Input;
/**
 * 组件控制器
 */
class Component extends Controller{

    protected function _initialize(){

    }

    public function index(){
        $fun = 'get'. ucfirst(strtolower(request()->param('tag')));
        if(method_exists($this, $fun)){
            // return call_user_func(array($this, $fun));
            $html1 = call_user_func(array($this, $fun));
            $this->assign('html1',$html1);
            $html2 = call_user_func(array($this, $fun));
            $this->assign('html2',$html2);
            return $this->fetch('common@test/index');
        }else{
            return "{$fun}方法不存在！";
        }
    }

    public function moreField($data=[]){
        $uniqid = uniqid();
        if(request()->isAjax()){
            if (empty(request()->param('title'))) return $this->error('字段名称不能为空！');
            $options = [
                'style'       => request()->param('style'),
                'title'       => request()->param('title'),
                'type'        => request()->param('type'),
                'name'        => "moreFields[{$uniqid}][value]",
                'id'          => $uniqid,
                'placeholder' => request()->param('placeholder'),
                'tips'        => request()->param('tips'),
                'hidden'      => [
                    "moreFields[{$uniqid}][type]"        => request()->param('type'),
                    "moreFields[{$uniqid}][name]"        => request()->param('name'),
                    "moreFields[{$uniqid}][title]"       => request()->param('title'),
                    "moreFields[{$uniqid}][placeholder]" => request()->param('placeholder'),
                    "moreFields[{$uniqid}][tips]"        => request()->param('tips'),
                    "moreFields[{$uniqid}][required]"    => request()->param('required'),
                    "moreFields[{$uniqid}][isHide]"      => request()->param('isHide'),
                    "moreFields[{$uniqid}][style]"       => request()->param('style')
                ]
            ];
            $Input = new Input;
            return $this->success($Input->set($options)->get());
        }else{
            $options = [
                // 'style'       => $data['style'],
                'title'       => $data['title'],
                'type'        => $data['type'],
                'name'        => "moreFields[{$uniqid}][value]",
                'id'          => $uniqid,
                'placeholder' => $data['placeholder'],
                // 'tips'        => $data['tips'],
                'value'       => isset($data['value'])?$data['value']:'',
                'hidden'      => [
                    "moreFields[{$uniqid}][type]"        => $data['type'],
                    "moreFields[{$uniqid}][name]"        => $data['name'],
                    "moreFields[{$uniqid}][title]"       => $data['title'],
                    "moreFields[{$uniqid}][placeholder]" => $data['placeholder'],
                    // "moreFields[{$uniqid}][tips]"        => $data['tips'],
                    "moreFields[{$uniqid}][required]"    => $data['required'],
                    "moreFields[{$uniqid}][isHide]"      => $data['isHide'],
                    // "moreFields[{$uniqid}][style]"       => $data['style']
                ]
            ];
            $Input = new Input;
            return $Input->set($options)->get();
        }
    }

    protected function getInput($options =  []){
        $Input = new Input();
        return $this->success($Input->set($options)->get());
    }

    protected function getSelect(){

    }

    protected function getTextarea(){

    }

}