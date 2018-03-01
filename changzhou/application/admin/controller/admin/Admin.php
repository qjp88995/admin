<?php
namespace app\admin\controller\admin;

use app\admin\controller\Common;
use app\model\database\AdminAdmin;
use app\model\database\AdminGroup;

class Admin extends Common{
    protected $iniPwd = '123456';
    public function select(){
        if(request()->has('group') && !empty(request()->param()['group'])){
            $groups = request()->param()['group'];
            $map['group'] = ['IN',$groups];
        }
        if(request()->has('title') && !empty(request()->param('title'))){
            $map['username|truename|tel'] = trim(request()->param('title'));
        }
        $page  = request()->param('page');
        $limit = request()->param('limit');
        $start = $limit*($page-1);
        $data  = AdminAdmin::where(@$map)->field('content,moreFields',true)->limit($start, $limit)->select();
        $total = AdminAdmin::where(@$map)->count();
        return json([
            'total' => $total,
            'data'  => $data
        ]);
    }
    public function find(){
        $_id = request()->param('_id');
        if(empty($_id)) return json(['code'=>false, 'msg'=>'主键不能为空！']);
        $data = AdminAdmin::find($_id);
        return json([
            'code' => true,
            'data' => $data
        ]);
    }
    public function insert(){
        $data = request()->param();
        if(!empty($data['_id'])) return json(['code'=>false, 'msg'=>'添加操作中不能出现主键']);
        $AdminAdmin = new AdminAdmin;
        $result = $this->validate($data, [
            'username'  => 'require|alphaDash|unique:admin_admin',
            'group'     => 'require',
        ],[
            'username.require'  => '用户名未填！',
            'username.alphaDash' => '用户名格式不正确！',
            'username.unique'   => '用户名已被使用！',
            'group.require'     => '分组信息不能为空！'
        ]);
        if($result!==true){
            return json(['code'=>false, 'msg'=>$result]);
        }
        $data['password'] = md5($this->iniPwd);
        $data['createAt'] = time();
        $result = $AdminAdmin->insert($data);
        if($result){
            return json(['code'=>true, 'msg'=>'添加成功！']);
        }
        return json(['code'=>false, 'msg'=>'添加失败！']);
    }
    public function update(){
        $data = request()->param();
        $AdminAdmin = new AdminAdmin;
        if(isset($data['reset']) && $data['reset']){
            $result = $this->validate($data, [
                '_id' => 'require'
            ],[
                '_id.require' => '主键不能为空！'
            ]);
            if($result!==true){
                return json(['code'=>false, 'msg'=>$result]);
            }
            $result = $AdminAdmin->update(['_id'=>$data['_id'], 'password'=>md5($this->iniPwd)]);
            if($result) {
                return json(['code'=>true, 'msg'=>'重置密码成功！']);
            }else{
                return json(['code'=>false, 'msg'=>'重置密码失败！']);
            }
        }
        $result = $this->validate($data, [
            '_id' => 'require',
            'username'  => 'require|alphaDash|unique:admin_admin',
            'group'     => 'require',
        ],[
            '_id.require' => '主键不能为空！',
            'username.require'  => '用户名未填！',
            'username.alphaDash' => '用户名格式不正确！',
            'username.unique'   => '用户名已被使用！',
            'group.require'     => '分组信息不能为空！'
        ]);
        if($result!==true){
            return json(['code'=>false, 'msg'=>$result]);
        }
        unset($data['createAt'],$data['password'],$data['system']);
        $data['updateAt'] = time();
        $result = $AdminAdmin->update($data);
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
        $info = AdminAdmin::find($_id);
        $group = AdminGroup::find($info->group);
        if(isset($group->system) && $group->system) abort(403);
        $result = AdminAdmin::destroy($_id);
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