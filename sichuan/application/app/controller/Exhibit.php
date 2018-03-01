<?php
namespace app\app\controller;

use app\app\controller\Common;
use app\venue\model\Exhibit as Exhbt;

class Exhibit extends Common{
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
        if(isset($args['isSelection'])){
            $map['isSelection'] = $args['isSelection'];
        }
        if(isset($args['pictures']) && $args['pictures']){
            $map['$where'] = 'this.pictures.length>0';
        }
        if(isset($args['videos']) && $args['videos']){
            $map['$where'] = 'this.videos.length>0';
        }
        if(isset($args['tdModels']) && $args['tdModels']){
            $map['$where'] = 'this.tdModels.length>0';
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
            $data = Exhbt::where($map)->field($fields)->limit($offset, $limit)->find();
            $data['_id'] = (string)$data->_id;
        }else{
            $data = Exhbt::where($map)->field($fields)->limit($offset, $limit)->order('sort','desc')->select();
            foreach ($data as $key => $value){
                $data[$key]['_id'] = (string)$value->_id;
                // $data[$key]['category'] = (string)$value['category']['id'];
            }
        }
        return json($data);
    }

    public function the3d(){
        $_id = trim(request()->param('_id'));
        if(!empty($_id)){
            $data = Exhbt::find($_id);
            if(empty($data) || count($data['tdModels'])<=0){
                return '没有找到资源！';
            }else{
                $this->assign('info',$data);
                return $this->fetch();
            }
        }else{
            return '请求无效！';
        }
    }
}