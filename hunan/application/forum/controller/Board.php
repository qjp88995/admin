<?php
namespace app\forum\controller;

use app\common\controller\Auth;
use app\forum\model\Board as B;

class Board extends Auth{
    public function index(){
        $boards = B::select();
        return json($boards);
    }
    public function detail(){
        $_id = request()->param('_id');
        $data = B::find($_id);
        return json($data);
    }

    public function insert(){
        $data = request()->param();
        if (!empty($data['_id'])) return json(['code'=>false, 'msg'=>'参数错误']);
        $B = new B;
        if(!empty($data['category'])){
            $category = Vct::field('title')->find($data['category']['id']['$oid']);
            $data['category'] = [
                'id' => new \MongoDB\BSON\ObjectID($data['category']['id']['$oid']),
                'title' => $category->title
            ];

        }
        if(!empty($data['hall'])){
            $hall = H::field('title')->find($data['hall']['id']['$oid']);
            $data['hall'] = [
                'id' => new \MongoDB\BSON\ObjectID($data['hall']['id']['$oid']),
                'title' => $hall->title
            ];

        }
        if(!empty($data['moreFields'])){
            foreach ($data['moreFields'] as $key => $value) {
                unset($data['moreFields'][$key]['_id']);
            }
        }
        unset($data['exhibits']);
        $data['createAt'] = time();
        $data['updateAt'] = time();
        $result = $B->insert($data);
        if ($result) {
            return json(['code'=>true, 'msg'=>'添加成功！']);
        }else{
            return json(['code'=>false, 'msg'=>'添加失败！']);
        }
    }

    public function update(){
        $data = request()->param();
        if (empty($data['_id'])) return json(['code'=>false, 'msg'=>'参数错误']);
        $B = new B;
        $data['_id'] = $data['_id']['$oid'];
        if(!empty($data['category'])){
            $category = Vct::field('title')->find($data['category']['id']['$oid']);
            $data['category'] = [
                'id' => new \MongoDB\BSON\ObjectID($data['category']['id']['$oid']),
                'title' => $category->title
            ];

        }
        if(!empty($data['hall'])){
            $hall = H::field('title')->find($data['hall']['id']['$oid']);
            $data['hall'] = [
                'id' => new \MongoDB\BSON\ObjectID($data['hall']['id']['$oid']),
                'title' => $hall->title
            ];

        }
        if(!empty($data['moreFields'])){
            foreach ($data['moreFields'] as $key => $value) {
                unset($data['moreFields'][$key]['_id']);
            }
        }
        unset($data['exhibits']);
        unset($data['createAt'],$data['updateAt']);
        $data['updateAt'] = time();
        $result = $B->update($data);
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
        $result = B::destroy($_id);
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