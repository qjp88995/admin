<?php
namespace app\volunteer\controller;

use think\Controller;
use app\model\database\VolunteerCategory;

class Category extends Controller{
    public function select(){
        $args = request()->param();
        if(!empty($args['_id']) && is_array($args['_id'])){
            foreach ($args['_id'] as $v) {
                $_ids[] = new \MongoDB\BSON\ObjectID($v);
            }
            $map['_id'] = ['IN', $_ids];
        }
        if(!empty($args['name']) && is_array($args['name'])){
            $map['name'] = ['IN', $args['name']];
        }
        if(!empty($args['parent'])){
            if(isset($args['parent']['id'])){
                $map['parent.id'] = $args['parent']['id'];
            }else if(isset($args['parent']['name'])){
                $map['parent.name'] = $args['parent']['name'];
            }else if(isset($args['parent']['title'])){
                $map['parent.title'] = $args['parent']['title'];
            }
        }
        if(isset($map) && !empty($map)){
            $data = VolunteerCategory::where($map)->field('content',true)->select();
            return json($data);
        }else{
            return json('参数错误');
        }
    }
    public function find(){
        $args = request()->param();
        if(!empty($args['_id'])){
            $map['_id'] = $args['_id'];
        }
        if(!empty($args['name'])){
            $map['name'] = $args['name'];
        }
        if(isset($map) && !empty($map)){
            $data = VolunteerCategory::where($map)->find();
            return json($data);
        }else{
            return json('参数错误');
        }
    }
}