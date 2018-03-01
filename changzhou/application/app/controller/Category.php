<?php
namespace app\app\controller;

use app\app\controller\Common;
use app\venue\model\Vcategory;

class Category extends Common{
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
        if(!empty($args['parent'])){
            if(isset($args['parent']['id'])){
                $map['parent.id'] = $args['parent']['id'];
            }else if(isset($args['parent']['name'])){
                $map['parent.name'] = $args['parent']['name'];
            }else if(isset($args['parent']['title'])){
                $map['parent.title'] = $args['parent']['title'];
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
            $data = Vcategory::where($map)->field($fields)->limit($offset, $limit)->find();
            $data['_id'] = (string)$data->_id;
        }else{
            $data = Vcategory::where($map)->field($fields)->limit($offset, $limit)->order('sort','desc')->select();
            foreach ($data as $key => $value){
                $data[$key]['_id'] = (string)$value->_id;
            }
        }
        return json($data);
    }
}