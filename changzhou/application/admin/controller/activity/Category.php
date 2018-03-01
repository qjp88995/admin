<?php
namespace app\admin\controller\activity;

use app\admin\controller\Common;
use app\model\database\ActivityCategory;

class Category extends Common{
    public function select(){
        if(request()->param('tree')){
            $map = [
                'parent' => ['exists',false]
            ];
            $cates = $this->getCates($map);
            return json($cates);
        }else{
            $cates = ActivityCategory::select();
            return json($cates);
        }
    }
    public function find(){
        if(empty(request()->param('_id'))) return json(['code'=>false,'msg'=>'参数错误！']);
        $data = ActivityCategory::find(request()->param('_id'));
        return json($data);
    }
    public function insert(){
        $data = request()->param();
        if (!empty($data['_id'])) return json(['code'=>false, 'msg'=>'参数错误']);
        $ActivityCategory = new ActivityCategory;
        if(!empty($data['parent'])){
            $category = $ActivityCategory->field('title,name')->find($data['parent']['id']);
            $data['parent'] = [
                'id'    => $data['parent']['id'],
                'title' => $category->title,
                'name'  => isset($category->name)?$category->name:''
            ];

        }
        $data['createAt'] = time();
        $data['updateAt'] = time();
        $result = $ActivityCategory->insert($data);
        if ($result) {
            return json(['code'=>true, 'msg'=>'添加成功！']);
        }else{
            return json(['code'=>false, 'msg'=>'添加失败！']);
        }
    }
    public function update(){
        $data = request()->param();
        if (empty($data['_id'])) return json(['code'=>false, 'msg'=>'参数错误']);
        $ActivityCategory = new ActivityCategory;
        if(!empty($data['parent'])){
            $category = $ActivityCategory->field('title,name')->find($data['parent']['id']);
            $data['parent'] = [
                'id'    => $data['parent']['id'],
                'title' => $category->title,
                'name'  => isset($category->name)?$category->name:''
            ];
        }
        unset($data['createAt'],$data['updateAt']);
        $data['updateAt'] = time();
        $result = $ActivityCategory->update($data);
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
        $result = ActivityCategory::destroy($_id);
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
        $ActivityCategory = new ActivityCategory;
        $cates = $ActivityCategory->where($map)->field('content',true)->order('sort','desc')->select();
        if(!empty($cates)){
            foreach ($cates as $k=>$v) {
                $map = [
                    'parent.id' => $v->_id,
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