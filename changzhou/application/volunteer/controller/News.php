<?php
namespace app\volunteer\controller;

use think\Controller;
use app\model\database\VolunteerNews;

class News extends Controller{
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
        if(!empty($args['category'])){
            if(isset($args['category']['id'])){
                $map['category.id'] = new \MongoDB\BSON\ObjectID($args['category']['id']);
            }else if(isset($args['category']['name'])){
                $map['category.name'] = $args['category']['name'];
            }else if(isset($args['category']['title'])){
                $map['category.title'] = $args['category']['title'];
            }
        }
        $page = isset($args['page']) && !empty($args['page']) ? $args['page'] : 1;
        $limit = isset($args['limit']) && !empty($args['limit'])  ? $args['limit']: null;
        $offset = !is_null($limit)? $limit*($page-1) : 0;
        if(isset($map) && !empty($map)){
            $data = VolunteerNews::where($map)->where('isShow', true)->field('content',true)->limit($offset, $limit)->order('sort','desc')->order('createAt','desc')->select();
            $total = VolunteerNews::where($map)->where('isShow', true)->count();
            return json([
                'total'=>$total,
                'data' =>$data
            ]);
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
            $data = VolunteerNews::where($map)->where('isShow', true)->find();
            if(!empty($data)){
                return json($data);
            }else{
                return json(null);
            }
        }else{
            return json('参数错误');
        }
    }
}