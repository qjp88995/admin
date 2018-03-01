<?php
namespace app\admin\controller\admin;

use app\admin\controller\Common;
use app\model\database\AdminPermissions;

class Permissions extends Common{
    public function select(){
        $data = $this->tree(['parent' => ['exists', false]]);
        return json($data);
    }
    public function find(){
        $_id = request()->param('_id');
        if(empty($_id)) return json(['code'=>false, 'msg'=>'主键不能为空！']);
        $data = AdminPermissions::find($_id);
        return json([
            'code' => true,
            'data' => $data
        ]);
    }
    public function insert(){
        $data = request()->param();
        if(!empty($data['_id'])) return json(['code'=>false, 'msg'=>'添加操作中不能出现主键']);
        $AdminPermissions = new AdminPermissions;
        $result = $this->validate($data, [
            'type'   => 'require|in:module,controller,action',
            'title'  => 'require|chsDash',
            'name'   => 'require',
            'parent' => 'requireIf:type,controller|requireIf:type,action'
        ],[
            'type.require'  => '类型未填！',
            'type.in'       => '类型错误！',
            'title.require' => '名称未填！',
            'title.chsDash' => '名称错误！',
            'name.require'  => '标识未填！',
            'parent.requireIf' => '所属模块或控制器未填！'
        ]);
        if($result!==true){
            return json(['code'=>false, 'msg'=>$result]);
        }
        $result = $AdminPermissions->insert($data);
        if($result){
            return json(['code'=>true, 'msg'=>'添加成功！']);
        }
        return json(['code'=>false, 'msg'=>'添加失败！']);
    }
    public function update(){
        $data = request()->param();
        unset($data['children']);
        $AdminPermissions = new AdminPermissions;
        $result = $this->validate($data, [
            '_id'    => 'require',
            'type'   => 'require|in:module,controller,action',
            'title'  => 'require|chsDash',
            'name'   => 'require',
            'parent' => 'requireIf:type,controller|requireIf:type,action'
        ],[
            '_id.require'   => '主键不能为空！',
            'type.require'  => '类型未填！',
            'type.in'       => '类型错误！',
            'title.require' => '名称未填！',
            'title.chsDash' => '名称错误！',
            'name.require'  => '标识未填！',
            'parent.requireIf' => '所属模块或控制器未填！'
        ]);
        if($result!==true){
            return json(['code'=>false, 'msg'=>$result]);
        }
        $result = $AdminPermissions->update($data);
        if ($result) {
            return json(['code'=>true, 'msg'=>'修改成功！']);
        }
        return json(['code'=>false, 'msg'=>'修改失败！']);
    }
    public function delete(){
        if (empty(request()->param()['_id'])) return json([
                'code' => false,
                'msg'  => '非法参数！'
            ]);
        $_id = request()->param()['_id'];
        $result = AdminPermissions::destroy($_id);
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
    protected function tree($map){
        $data = AdminPermissions::where($map)->select();
        foreach ($data as $key => $value) {
            $children = $this->tree(['parent' => $value->_id]);
            if(!empty($children)) $data[$key]['children'] = $children;
        }
        return $data;
    }
}