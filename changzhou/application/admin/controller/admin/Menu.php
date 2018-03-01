<?php
namespace app\admin\controller\admin;

use app\admin\controller\Common;
use app\model\database\AdminMenu;

class Menu extends Common{
    public function select(){
        $data = $this->tree(['parent' => ['exists', false]],['type' => 'top']);
        return json($data);
    }
    public function find(){
        $_id = request()->param('_id');
        if(empty($_id)) return json(['code'=>false, 'msg'=>'主键不能为空！']);
        $data = AdminMenu::find($_id);
        return json([
            'code' => true,
            'data' => $data
        ]);
    }
    public function insert(){
        $data = request()->param();
        if(!empty($data['_id'])) return json(['code'=>false, 'msg'=>'添加操作中不能出现主键']);
        $AdminMenu = new AdminMenu;
        $result = $this->validate($data, [
            'type'   => 'require|in:menu,submenu,item,button',
            'title'  => 'require',
            'parent' => 'requireIf:type,submenu|requireIf:type,item|requireIf:type,button'
        ],[
            'type.require'  => '类型未填！',
            'type.in'       => '类型错误！',
            'title.require' => '名称未填！',
            'parent.requireIf' => '父子关系未标明！'
        ]);
        if($result!==true){
            return json(['code'=>false, 'msg'=>$result]);
        }
        $result = $AdminMenu->insert($data);
        if($result){
            return json(['code'=>true, 'msg'=>'添加成功！']);
        }
        return json(['code'=>false, 'msg'=>'添加失败！']);
    }
    public function update(){
        $data = request()->param();
        unset($data['children']);
        $AdminMenu = new AdminMenu;
        $result = $this->validate($data, [
            '_id'    => 'require',
            'type'   => 'require|in:menu,submenu,item,button',
            'title'  => 'require',
            'parent' => 'requireIf:type,submenu|requireIf:type,item|requireIf:type,button'
        ],[
            '_id.require'   => '主键不能为空！',
            'type.require'  => '类型未填！',
            'type.in'       => '类型错误！',
            'title.require' => '名称未填！',
            'parent.requireIf' => '父子关系未标明！'
        ]);
        if($result!==true){
            return json(['code'=>false, 'msg'=>$result]);
        }
        $result = $AdminMenu->update($data);
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
        $result = AdminMenu::destroy($_id);
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
        $data = AdminMenu::where($map)->select();
        foreach ($data as $key => $value) {
            $children = $this->tree(['parent' => (string)$value->_id]);
            if(!empty($children)) $data[$key]['children'] = $children;

        }
        return $data;
    }
}