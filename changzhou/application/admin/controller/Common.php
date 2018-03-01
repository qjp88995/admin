<?php
namespace app\admin\controller;

use think\Controller;
use think\Session;
use app\model\database\AdminGroup;
use app\model\database\AdminPermissions;
class Common extends Controller{
    public function _initialize(){
        if(request()->action()!=='login'){
            if(!Session::has('_id','admin')){
                abort(401);
            }
            if(strtolower(request()->controller())!='my'){
                $this->checkPermissions();
            }
        }
    }
    protected function checkPermissions(){
        $module = strtolower(request()->module());
        $controller = strtolower(request()->controller());
        $action = strtolower(request()->action());
        $group = AdminGroup::find(session('group', '', 'admin'));
        if(isset($group->system) && $group->system) return true;
        $permissions = $group->permissions;
        $hasModule = AdminPermissions::where([
            'name' => $module,
            'type' => 'module',
            '_id'  => ['in',$permissions]
        ])->find();
        if(!$hasModule) abort('403');
        $hasController = AdminPermissions::where([
            'name' => $controller,
            'type' => 'controller',
            '_id'  => ['in',$permissions]
        ])->find();
        if(!$hasController) abort('403');
        $hasAction = AdminPermissions::where([
            'name' => $action,
            'type' => 'action',
            '_id'  => ['in', $permissions]
        ])->find();
        if(!$hasAction) abort('403');
    }
}