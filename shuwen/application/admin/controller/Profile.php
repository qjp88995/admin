<?php
namespace app\admin\controller;

use app\common\controller\Auth;
use app\model\Profile as Pro;
// use app\model\ProectionCate as ProCate;

class Profile extends Auth{
    public function index(){
        if(request()->has('title') && !empty(request()->param('title'))){
            $map['title'] = ['like', trim(request()->param('title'))];
        }
        if(request()->has('name') && !empty(request()->param('name'))){
            $map['name'] = ['like', trim(request()->param('name'))];
        }
        if(request()->has('createAt') && !empty(request()->param('createAt'))){
            $time = explode('/', request()->param('createAt'));
            foreach ($time as $k => $v) {
                $time[$k] = strtotime($v);
            }
            $map['createAt'] = ['between',$time];
        }
        $sort = request()->param('year')=='ascend'?'asc':'desc';
        $page = request()->param('page');
        $limit = request()->param('limit');
        $start = $limit*($page-1);
        $data = Pro::where(@$map)->field('content',true)->limit($start, $limit)->order('year',$sort)->select();
        $count = Pro::where(@$map)->count();
        return json([
            'count' => $count,
            'data'  => $data
        ]);
    }
    public function detail(){
        $_id = request()->param('_id');
        $name = request()->param('name');
        if($_id){
            $data = Pro::find($_id);
        }elseif($name){
            $data = Pro::where(['name'=>$name])->find();
        }
        if($data){
            return json($data);
        }else{
            return json_encode([],JSON_FORCE_OBJECT);
        }
    }

    public function insert(){
        $data = request()->param();
        if (!empty($data['_id'])) return json(['code'=>false, 'msg'=>'参数错误']);
        $Pro = new Pro;
        if(!empty($data['category'])){
            $category = Ct::field('title')->find($data['category']['id']['$oid']);
            $data['category'] = [
                'id' => new \MongoDB\BSON\ObjectID($data['category']['id']['$oid']),
                'title' => $category->title
            ];

        }
        if(!empty($data['moreFields'])){
            foreach ($data['moreFields'] as $key => $value) {
                unset($data['moreFields'][$key]['_id']);
            }
        }
        $data['createAt'] = time();
        $data['updateAt'] = time();
        $result = $Pro->insert($data);
        if ($result) {
            return json(['code'=>true, 'msg'=>'添加成功！']);
        }else{
            return json(['code'=>false, 'msg'=>'添加失败！']);
        }
    }

    public function update(){
        $data = request()->param();
        if (empty($data['_id'])) return json(['code'=>false, 'msg'=>'参数错误']);
        $Pro = new Pro;
        $data['_id'] = $data['_id']['$oid'];
        if(!empty($data['category'])){
            $category = Ct::field('title')->find($data['category']['id']['$oid']);
            $data['category'] = [
                'id' => new \MongoDB\BSON\ObjectID($data['category']['id']['$oid']),
                'title' => $category->title
            ];

        }
        if(!empty($data['moreFields'])){
            foreach ($data['moreFields'] as $key => $value) {
                unset($data['moreFields'][$key]['_id']);
            }
        }
        unset($data['createAt'],$data['updateAt']);
        $data['updateAt'] = time();
        $result = $Pro->update($data);
        if ($result) {
            return json(['code'=>true, 'msg'=>'修改成功！']);
        }else{
            return json(['code'=>false, 'msg'=>'修改失败！']);
        }
    }

    public function delete(){
        if (empty(request()->param()['_id'])) return json([
                'code' => false,
                'msg'  => '非法参数！'
            ]);
        $_id = request()->param()['_id'];
        $result = Pro::destroy($_id);
        if ($result) {
            return json([
                'code' => true,
                'msg'  => '删除成功！'
            ]);
        }else{
            return json([
                'code' => false,
                'msg'  => '删除成功！'
            ]);
        }
    }
}