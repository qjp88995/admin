<?php
namespace app\admin\controller;

use app\common\controller\Auth;
use app\model\Exhibition as ExhibitionList;
use app\model\ExhibitionCate;

class Exhibition extends Auth{
    public function index(){
        if(request()->has('category') && !empty(request()->param()['category'])){
            $arr = request()->param()['category'];
            foreach ($arr as $v) {
                $cates[] = new \MongoDB\BSON\ObjectID($v);
            }
            $map['category.id'] = ['IN',$cates];
        }
        if(request()->has('title') && !empty(request()->param('title'))){
            $map['title'] = ['like', trim(request()->param('title'))];
        }
        if(request()->has('createAt') && !empty(request()->param('createAt'))){
            $time = explode('/', request()->param('createAt'));
            foreach ($time as $k => $v) {
                $time[$k] = strtotime($v);
            }
            $map['createAt'] = ['between',$time];
        }
        if(request()->has('isShow') && !empty(request()->param()['isShow'])){
            $isShow = request()->param()['isShow'];
            foreach ($isShow as $k => $v) {
                $isShow[$k] = intval($v);
            }
            $map['isShow'] = ['in', $isShow];
        }
        if(request()->has('isTop') && !empty(request()->param()['isTop'])){
            $isTop = request()->param()['isTop'];
            foreach ($isTop as $k => $v) {
                $isTop[$k] = intval($v);
            }
            $map['isTop'] = ['in', $isTop];
        }
        if(request()->has('status') && !empty(request()->param()['status'])){
            $status = request()->param()['status'];
            foreach ($status as $k => $v) {
                $status[$k] = intval($v);
            }
            $map['status'] = ['in', $status];
        }
        $sort = request()->param('sort')=='ascend'?'asc':'desc';
        $page = request()->param('page');
        $limit = request()->param('limit');
        $start = $limit*($page-1);
        $data = ExhibitionList::where(@$map)->field('content,moreFields',true)->limit($start, $limit)->order('sort',$sort)->select();
        $count = ExhibitionList::where(@$map)->count();
        return json([
            'count' => $count,
            'data'  => $data
        ]);
    }
    public function detail(){
        $_id = request()->param('_id');
        $data = ExhibitionList::find($_id);
        return json($data);
    }

    public function insert(){
        $data = request()->param();
        if (!empty($data['_id'])) return json(['code'=>false, 'msg'=>'参数错误']);
        $ExhibitionList = new ExhibitionList;
        if(!empty($data['category'])){
            $category = ExhibitionCate::field('title,name')->find($data['category']['id']['$oid']);
            $data['category'] = [
                'id'    => new \MongoDB\BSON\ObjectID($data['category']['id']['$oid']),
                'title' => $category->title,
                'name'  => $category->name
            ];
        }
        if(!empty($data['moreFields'])){
            foreach ($data['moreFields'] as $key => $value) {
                unset($data['moreFields'][$key]['_id']);
            }
        }
        $data['createAt'] = time();
        $data['updateAt'] = time();
        $result = $ExhibitionList->insert($data);
        if ($result) {
            return json(['code'=>true, 'msg'=>'添加成功！']);
        }else{
            return json(['code'=>false, 'msg'=>'添加失败！']);
        }
    }

    public function update(){
        $data = request()->param();
        if (empty($data['_id'])) return json(['code'=>false, 'msg'=>'参数错误']);
        $ExhibitionList = new ExhibitionList;
        $data['_id'] = $data['_id']['$oid'];
        if(!empty($data['category'])){
            $category = ExhibitionCate::field('title,name')->find($data['category']['id']['$oid']);
            $data['category'] = [
                'id'    => new \MongoDB\BSON\ObjectID($data['category']['id']['$oid']),
                'title' => $category->title,
                'name'  => $category->name
            ];

        }
        if(!empty($data['moreFields'])){
            foreach ($data['moreFields'] as $key => $value) {
                unset($data['moreFields'][$key]['_id']);
            }
        }
        unset($data['createAt'],$data['updateAt']);
        $data['updateAt'] = time();
        $result = $ExhibitionList->update($data);
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
        $result = ExhibitionList::destroy($_id);
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