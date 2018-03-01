<?php
namespace app\app\controller;

use app\app\controller\Common;
use app\article\model\Article as Atcl;

class Article extends Common{
    public function index(){
        $args = request()->param();
        $map = [];
        $map['isShow'] = true;
        if(!empty($args['_id'])){
            if(is_array($args['_id'])){
                foreach ($args['_id'] as $v) {
                    $_ids[] = new \MongoDB\BSON\ObjectID($v);
                }
                $map['_id'] = ['IN', $_ids];
            }else{
                $map['_id'] = new \MongoDB\BSON\ObjectID($args['_id']);
            }
        }
        if(!empty($args['name'])){
            if(is_array($args['name'])){
                $map['name'] = ['IN', $args['name']];
            }else{
                $map['name'] = $args['name'];
            }
        }
        if(!empty($args['guideNum'])){
            if(is_array($args['guideNum'])){
                $map['guideNum'] = ['IN', $args['guideNum']];
            }else{
                $map['guideNum'] = $args['guideNum'];
            }
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
        $fields = [];
        if(!empty($args['fields']) && is_array($args['fields'])){
            $fields = $args['fields'];
        }

        // 分页
        $page = isset($args['page']) && !empty($args['page']) ? $args['page'] : 1;
        $limit = isset($args['limit']) && !empty($args['limit'])  ? $args['limit']: null;
        $offset = !is_null($limit)? $limit*($page-1) : 0;
        if(isset($args['one']) && $args['one']){
            $data = Atcl::where($map)->field($fields)->limit($offset, $limit)->find();
            $data['_id'] = (string)$data->_id;
        }else{
            $data = Atcl::where($map)->field($fields)->limit($offset, $limit)->order('sort','desc')->select();
            foreach ($data as $key => $value){
                $data[$key]['_id'] = (string)$value->_id;
                // $data[$key]['category'] = (string)$value['category']['id'];
            }
        }
        return json($data);
    }

    public function detail(){
        $_id = request()->route('_id');
        if(empty($_id)) return '资源不存在';
        $detail = Atcl::find($_id);
        if($detail){
            $this->assign('detail',$detail);
            return $this->fetch('detail');
        }else{
            return $this->fetch('error/404');
        }
    }
}