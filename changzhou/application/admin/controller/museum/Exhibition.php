<?php
namespace app\admin\controller\museum;

use app\admin\controller\Common;
use app\model\database\MuseumCategory;
use app\model\database\MuseumExhibition;

class Exhibition extends Common{
    public function select(){
        if(!request()->has('selectAll')){
            if(request()->has('category') && !empty(request()->param()['category'])){
                $cates = request()->param()['category'];
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
            $data = MuseumExhibition::where(@$map)->field('content',true)->limit($start, $limit)->order('sort',$sort)->select();
            $count = MuseumExhibition::where(@$map)->count();
            return json([
                'count' => $count,
                'data'  => $data
            ]);
        }else{
            $data = MuseumExhibition::field('content',true)->select();
            return json($data);
        }
    }
    public function find(){
        $_id = request()->param('_id');
        $data = MuseumExhibition::find($_id);
        return json($data);
    }

    public function insert(){
        $data = request()->param();
        if (!empty($data['_id'])) return json(['code'=>false, 'msg'=>'参数错误']);
        $MuseumExhibition = new MuseumExhibition;
        if(!empty($data['category'])){
            $category = MuseumCategory::field('title,name')->find($data['category']['id']);
            $data['category'] = [
                'id'    => $data['category']['id'],
                'title' => $category->title,
                'name'  => isset($category->name)?$category->name:''
            ];

        }
        $data['createAt'] = time();
        $data['updateAt'] = time();
        $result = $MuseumExhibition->insert($data);
        if ($result) {
            return json(['code'=>true, 'msg'=>'添加成功！']);
        }else{
            return json(['code'=>false, 'msg'=>'添加失败！']);
        }
    }

    public function update(){
        $data = request()->param();
        if (empty($data['_id'])) return json(['code'=>false, 'msg'=>'参数错误']);
        $MuseumExhibition = new MuseumExhibition;
        if(!empty($data['category'])){
            $category = MuseumCategory::field('title,name')->find($data['category']['id']);
            $data['category'] = [
                'id'    => $data['category']['id'],
                'title' => $category->title,
                'name'  => isset($category->name)?$category->name:''
            ];

        }
        unset($data['createAt'],$data['updateAt']);
        $data['updateAt'] = time();
        $result = $MuseumExhibition->update($data);
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
        $result = MuseumExhibition::destroy($_id);
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