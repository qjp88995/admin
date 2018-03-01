<?php
namespace app\admin\controller;

use app\admin\controller\Common;
use app\model\database\AdminMenu;
use app\model\database\AdminGroup;
use app\model\database\AdminAdmin;

class My extends Common{
    protected $menus = [];
    public function _initialize(){
        $userinfo = AdminAdmin::find(session('_id','','admin'));
        $groupinfo = AdminGroup::find(session('group','','admin'));
        $this->menus = $groupinfo->menu;
    }
    //获取首页链接
    public function getIndex(){
        $data = $this->menu();
        $link = '';
        foreach ($data as $key => $value) {
            $link = $data[$key]['link'];
            break;
        }
        return json($link);
    }
    //获取菜单
    public function getMenu(){
        $data = $this->menu();
        return json($data);
    }
    //修改密码
    public function editPwd(){
        $data = request()->param();
        $result = $this->validate($data, [
            'oldPwd'   => 'require',
            'newPwd'   => 'require|different:oldPwd',
            'newPwd2'  => 'require|confirm:newPwd',
        ],[
            'oldPwd.require'   => '原密码不能为空！',
            'newPwd.require'   => '新密码不能为空！',
            'newPwd.different' => '新密码不能与旧密码相同！',
            'newPwd2.require'  => '确认密码不能为空！',
            'newPwd2.confirm'  => '两次密码输入不一致！'
        ]);
        if(true !== $result){
            return json([
                'code' => false,
                'msg'  => $result
            ]);
        }
        $info = AdminAdmin::find(session('_id','admin'));
        if(md5($data['oldPwd']) !== $info->password){
            return json([
                'code' => false,
                'msg'  => '原密码不正确！'
            ]);
        }
        $res = AdminAdmin::where('_id',session('_id','','admin'))->update(['password'=>md5($data['newPwd'])]);
        if($res){
            return json([
                'code' => true,
                'msg'  => '修改成功！'
            ]);
        }else{
            return json([
                'code' => false,
                'msg'  => '修改失败！'
            ]);
        }
    }
    //登录
    public function login(){
        $data = request()->param();
        $info = AdminAdmin::where(['username'=>$data['username'],'password'=>md5($data['password'])])->find();
        if($info){
            if($info->enable){
                $info = $info->toArray();
                unset($info['password']);
                foreach ($info as $key => $value) {
                    session($key, $value, 'admin');
                }
                return json([
                    'code' => true,
                    'msg'  => '登录成功！'
                ]);
            }else{
                return json([
                    'code' => false,
                    'msg'  => '您的账户已被禁用'
                ]);
            }
        }else{
            return json([
                'code' => false,
                'msg'  => '用户名或密码错误！'
            ]);
        }
    }
    //退出
    public function logout(){
        session(null, 'admin');
        return json([
            'code' => true,
            'msg'  => '退出成功！'
        ]);
    }

    protected function menu(){
        $data = $this->tree([
            'parent' => ['exists', false],
            '_id'    => ['IN', $this->menus],
            'type'   => 'menu'
        ]);
        foreach ($data as $key => $value) {
            if(isset($value['children'])){
                $data[$key]['link'] = $value['children'][0]['children'][0]['link'];
            }
        }
        return $data;
    }
    protected function tree($map){
        $data = AdminMenu::where($map)->select();
        foreach ($data as $key => $value) {
            $children = $this->tree([
                'parent' => (string)$value->_id,
                '_id'    => ['IN', $this->menus],
                'type' => ['NEQ', 'button']
            ]);
            if(!empty($children)) $data[$key]['children'] = $children;

        }
        return $data;
    }
}