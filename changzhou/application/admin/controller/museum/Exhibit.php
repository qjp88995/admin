<?php
namespace app\admin\controller\museum;

use app\admin\controller\Common;
use app\model\database\MuseumExhibit;
use app\model\database\MuseumExhibition;

class Exhibit extends Common{
    public function select(){
        if(request()->has('exhibition') && !empty(request()->param()['exhibition'])){
            $cates = request()->param()['exhibition'];
            $map['exhibition.id'] = ['IN',$cates];
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
        if(request()->has('status') && !empty(request()->param()['status'])){
            $status = request()->param()['status'];
            foreach ($status as $k => $v) {
                $status[$k] = intval($v);
            }
            $map['status'] = ['in', $status];
        }
        $sort  = request()->param('sort')=='ascend'?'asc':'desc';
        $page  = request()->param('page');
        $limit = request()->param('limit');
        $start = $limit*($page-1);
        $data  = MuseumExhibit::where(@$map)->field('content,moreFields',true)->limit($start, $limit)->order('sort',$sort)->order('guideNum','desc')->select();
        $count = MuseumExhibit::where(@$map)->count();
        return json([
            'count' => $count,
            'data'  => $data
        ]);
    }
    public function find(){
        $_id = request()->param('_id');
        $data = MuseumExhibit::find($_id);
        return json($data);
    }

    public function insert(){
        $data = request()->param();
        if (!empty($data['_id'])) return json(['code'=>false, 'msg'=>'参数错误']);
        $MuseumExhibit = new MuseumExhibit;
        if(!empty($data['exhibition'])){
            $exhibition = MuseumExhibition::field('title,name')->find($data['exhibition']['id']);
            $data['exhibition'] = [
                'id'    => $data['exhibition']['id'],
                'title' => $exhibition->title,
                'name'  => isset($exhibition->name)?$exhibition->name:''
            ];
        }
        $data['createAt'] = time();
        $data['updateAt'] = time();
        $result = $MuseumExhibit->insert($data);
        if ($result) {
            return json(['code'=>true, 'msg'=>'添加成功！']);
        }else{
            return json(['code'=>false, 'msg'=>'添加失败！']);
        }
    }

    public function update(){
        $data = request()->param();
        if (empty($data['_id'])) return json(['code'=>false, 'msg'=>'参数错误']);
        $MuseumExhibit = new MuseumExhibit;
        if(!empty($data['exhibition'])){
            $exhibition = MuseumExhibition::field('title,name')->find($data['exhibition']['id']);
            $data['exhibition'] = [
                'id'    => $data['exhibition']['id'],
                'title' => $exhibition->title,
                'name'  => isset($exhibition->name)?$exhibition->name:''
            ];
        }
        if(!empty($data['uuid'])){
            $data['uuid'] = strtoupper($data['uuid']);
        }
        unset($data['createAt'],$data['updateAt']);
        $data['updateAt'] = time();
        $result = $MuseumExhibit->update($data);
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
        $result = MuseumExhibit::destroy($_id);
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