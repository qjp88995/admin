<?php
namespace app\venue\controller;

use app\common\controller\Auth;
use app\venue\model\Hall as H;

class Hall extends Auth{
    public function index(){
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
        $sort = request()->param('sort')=='ascend'?'asc':'desc';
        $page = request()->param('page');
        $limit = request()->param('limit');
        $start = $limit*($page-1);
        $data = H::where(@$map)->field('content,moreFields',true)->limit($start, $limit)->order('sort',$sort)->select();
        $count = H::where(@$map)->count();
        return json([
            'count' => $count,
            'data'  => $data
        ]);
    }
    public function detail(){
        $_id = request()->param('_id');
        $data = H::find($_id);
        return json($data);
    }

    public function insert(){
        $data = request()->param();
        if (!empty($data['_id'])) return json(['code'=>false, 'msg'=>'参数错误']);
        $H = new H;
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
        $result = $H->insert($data);
        if ($result) {
            return json(['code'=>true, 'msg'=>'添加成功！']);
        }else{
            return json(['code'=>false, 'msg'=>'添加失败！']);
        }
    }

    public function update(){
        $data = request()->param();
        if (empty($data['_id'])) return json(['code'=>false, 'msg'=>'参数错误']);
        $H = new H;
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
        $result = $H->update($data);
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
        $result = H::destroy($_id);
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