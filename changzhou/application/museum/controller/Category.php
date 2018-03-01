<?php
namespace app\museum\controller;

use think\Controller;
use app\model\database\MuseumCategory;

class Category extends Controller{
    public function select(){
        if(request()->param('tree')){
            $map = [
                'parent' => ['exists',false]
            ];
            $cates = $this->getCates($map);
            return json($cates);
        }else{
            $cates = MuseumCategory::select();
            return json($cates);
        }
    }
    public function find(){
        if(empty(request()->param('_id'))) return json(['code'=>false,'msg'=>'参数错误！']);
        $data = MuseumCategory::find(request()->param('_id'));
        return json($data);
    }
    protected function getCates($map){
        $MuseumCategory = new MuseumCategory;
        $cates = $MuseumCategory->where($map)->field('content',true)->order('sort','desc')->select();
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