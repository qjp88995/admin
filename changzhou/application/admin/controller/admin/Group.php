<?php
namespace app\admin\controller\admin;

use app\admin\controller\Common;
use app\model\database\AdminGroup;

class Group extends Common{
    public function select(){
        $data = AdminGroup::select();
        return json($data);
    }
    public function find(){
        $_id = request()->param('_id');
        if(empty($_id)) return json(['code'=>false, 'msg'=>'主键不能为空！']);
        $data = AdminGroup::find($_id);
        return json([
            'code' => true,
            'data' => $data
        ]);
    }
    public function insert(){
        $data = request()->param();
        if(!empty($data['_id'])) return json(['code'=>false, 'msg'=>'添加操作中不能出现主键']);
        $AdminGroup = new AdminGroup;
        $result = $this->validate($data, [
            'title'  => 'require',
        ],[
            'type.require'  => '类型未填！'
        ]);
        if($result!==true){
            return json(['code'=>false, 'msg'=>$result]);
        }
        $data['createAt'] = time();
        $result = $AdminGroup->insert($data);
        if($result){
            return json(['code'=>true, 'msg'=>'添加成功！']);
        }
        return json(['code'=>false, 'msg'=>'添加失败！']);
    }
    public function update(){
        $data = request()->param();
        $AdminGroup = new AdminGroup;
        $result = $this->validate($data, [
            '_id'    => 'require',
            'title'  => 'require',
        ],[
            '_id.require'   => '主键不能为空！',
            'title.require' => '名称未填！',
        ]);
        if($result!==true){
            return json(['code'=>false, 'msg'=>$result]);
        }
        unset($data['createAt']);
        $result = $AdminGroup->update($data);
        if ($result) {
            return json(['code'=>true, 'msg'=>'修改成功！']);
        }
        return json(['code'=>false, 'msg'=>'修改失败！']);
    }
    public function delete(){
        $_id = request()->param('_id');
        if (empty($_id)) return json([
                'code' => false,
                'msg'  => '非法参数！'
            ]);
        $result = AdminGroup::where(['system'=>['exists',false]])->destroy($_id);
        if ($result) {
            return json([
                'code' => true,
                'msg'  => '删除成功！'
            ]);
        }
        return json([
            'code' => false,
            'msg'  => '删除失败！无权限删除！'
        ]);
    }
}