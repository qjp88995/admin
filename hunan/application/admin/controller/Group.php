<?php
namespace app\admin\controller;

use app\common\controller\Auth;
use app\admin\model\Group as Gp;

class Group extends Auth{
    public function index(){
        if(request()->isAjax()){
            if(!trim(empty(request()->param('title')))){
                $where['title'] = ['like', trim(request()->param('title'))];
            }
            if(!trim(empty(request()->param('all')))){
                return Gp::select();
            }
            if(!trim(empty(request()->param('_id')))){
                return Gp::find(request()->param('_id'));
            }
            $list = Gp::where(@$where)->paginate();
            return $list;
        }else{
            return $this->fetch();
        }
    }

    public function insert(){
        if(request()->has('title') && request()->has('intro') && request()->has('auth')){
            $data = [
                'title'       => request()->param('title'),
                'intro'       => request()->param('intro'),
                'auths'       => request()->param()['auth'],
                'deleteAt'    => 0,
            ];
            $Gp = new Gp;
            $result = $Gp->insert($data);
            if(request()->isAjax()){
                if($result){
                    return ['code'=>true, 'msg'=>'添加成功！'];
                }else{
                    return ['code'=>false, 'msg'=>'添加成功！'];
                }
            }else{
                if($result){
                    return $this->success('添加成功!');
                }else{
                    return $this->error('添加失败！');
                }
            }
        }else{
            return ['code'=>false, 'msg'=>'参数有误！'];
        }
    }

    public function update(){
        if (empty(request()->param('_id')) && request()->isAjax()) return ['code'=>false, 'msg'=>'参数有误！'];
        if (empty(request()->param('_id'))) return $this->error('非法操作！');
        $data = [];
        if(request()->has('title')){
            $data['title'] = request()->param()['title'];
        }
        if(request()->has('intro')){
            $data['intro'] = request()->param()['intro'];
        }
        if(request()->has('auths')){
            $data['auths'] = array_values(request()->param()['auths']);
        }
        $Gp = new Gp;
        $result = $Gp->where('_id', request()->param('_id'))->update($data);
        if(request()->isAjax()){
            if($result){
                return ['code'=>true, 'msg'=>'更新成功！'];
            }else{
                return ['code'=>false, 'msg'=>'更新成功！'];
            }
        }else{
            if($result){
                return $this->success('更新成功!');
            }else{
                return $this->error('更新失败！');
            }
        }
    }

    public function delete(){
        if(request()->isAjax()){
            if (empty(request()->param('_id'))) return ['code'=>false, 'msg'=>'参数错误！'];;
            $_id = request()->param('_id');
            $result = Gp::destroy($_id);
            if($result) {
                return ['code'=>true, 'msg'=>'删除成功！'];
            }else{
                return ['code'=>false, 'msg'=>'删除失败！'];
            }
        }else{
            return ['code'=>false, 'msg'=>'删除失败！参数有误！'];
        }
    }
}