<?php
namespace app\venue\controller;

use app\common\controller\Auth;
use app\venue\model\Vcategory as Vct;

class Cate extends Auth{
    public function index(){
        if(request()->param('tree')){
            $map = [
                'parent' => ['exists',false]
            ];
            $cates = $this->getCates($map);
            return json($cates);
        }else{
            $cates = Vct::select();
            return json($cates);
        }
    }
    public function detail(){
        if(empty(request()->param('_id'))) return json(['code'=>false,'msg'=>'参数错误！']);
        $data = Vct::find(request()->param('_id'));
        return json($data);
    }
    public function insert(){
        $data = request()->param();
        if (!empty($data['_id'])) return json(['code'=>false, 'msg'=>'参数错误']);
        $Vct = new Vct;
        if(!empty($data['parent'])){
            $category = $Vct->field('title,name')->find($data['parent']['id']['$oid']);
            $data['parent'] = [
                'id' => new \MongoDB\BSON\ObjectID($data['parent']['id']['$oid']),
                'title' => $category->title,
                'name' => $category->name,
            ];

        }
        if(!empty($data['moreFields'])){
            foreach ($data['moreFields'] as $key => $value) {
                unset($data['moreFields'][$key]['_id']);
            }
        }
        $data['createAt'] = time();
        $data['updateAt'] = time();
        $result = $Vct->insert($data);
        if ($result) {
            return json(['code'=>true, 'msg'=>'添加成功！']);
        }else{
            return json(['code'=>false, 'msg'=>'添加失败！']);
        }
    }
    public function update(){
        $data = request()->param();
        if (empty($data['_id'])) return json(['code'=>false, 'msg'=>'参数错误']);
        $Vct = new Vct;
        $data['_id'] = $data['_id']['$oid'];
        if(!empty($data['parent'])){
            $category = $Vct->field('title,name')->find($data['parent']['id']['$oid']);
            $data['parent'] = [
                'id' => new \MongoDB\BSON\ObjectID($data['parent']['id']['$oid']),
                'title' => $category->title,
                'name' => $category->name,
            ];
        }
        if(!empty($data['moreFields'])){
            foreach ($data['moreFields'] as $key => $value) {
                unset($data['moreFields'][$key]['_id']);
            }
        }
        unset($data['createAt'],$data['updateAt']);
        $data['updateAt'] = time();
        $result = $Vct->update($data);
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
        $result = Vct::destroy($_id);
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
    protected function getCates($map){
        $Vct = new Vct;
        $cates = $Vct->where($map)->order('sort','desc')->select();
        if(!empty($cates)){
            foreach ($cates as $k=>$v) {
                $map = [
                    'parent.id' => new \MongoDB\BSON\ObjectID((string)$v->_id),
                ];
                $cates[$k]->children = $this->getCates($map);
                if(empty($cates[$k]->children)){
                    unset($cates[$k]->children);
                }
            }
        }
        return $cates;
    }
}