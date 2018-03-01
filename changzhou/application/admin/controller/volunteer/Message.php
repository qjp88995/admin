<?php
namespace app\admin\controller\volunteer;

use app\admin\controller\Common;
use app\model\database\VolunteerMessage;

class Message extends Common{
    public function select(){
        if(request()->has('type')){
            $map['type'] = request()->param('type');
        }
        $data = VolunteerMessage::where(@$map)->select();
        return json([
            'code' => true,
            'data' => $data
        ]);
    }
    public function find(){
        $_id = request()->param('_id');
        if(empty($_id)) return json(['code'=>false,'msg'=>'参数错误！']);
        $result = VolunteerMessage::find($_id);
        return json([
            'code' => true,
            'data' => $result
        ]);
    }
    public function insert(){
        $data = request()->param();
        $result = VolunteerMessage::insert($data);
        if($result){
            return json([
                'code' => true,
                'msg'  => '添加成功！'
            ]);
        }
        return json([
            'code' => false,
            'msg'  => '添加失败！'
        ]);
    }
    public function update(){
        $data = request()->param();
        if(empty($data['_id'])) return json(['code'=>false,'msg'=>'主键不能为空！']);
        $result = VolunteerMessage::update($data);
        if($result){
            return json([
                'code' => true,
                'msg'  => '更新成功！'
            ]);
        }
        return json([
            'code' => false,
            'msg'  => '更新失败！'
        ]);
    }
    public function delete(){
        $_id = request()->param();
        if(empty($_id)) return json(['code'=>false,'msg'=>'缺少主键！']);
        $result = VolunteerMessage::destroy($_id);
        if($result) return json([
            'code' => true,
            'msg'  => '删除成功！'
        ]);
        return json([
            'code' => false,
            'msg'  => '删除失败！'
        ]);
    }
}