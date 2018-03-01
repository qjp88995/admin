<?php
namespace app\activity\controller;

use app\activity\controller\Common;
use app\model\database\ActivityUser;
use app\model\database\ActivityBooked;
use app\model\database\ActivityActivity;
use app\model\database\WechatUser;

class User extends Common{
    public function getMyInfo(){
        $_id = session('_id', '', 'wechat');
        $user = WechatUser::where('_id', $_id)->find();
        if($user){
            return json([
                'code' => true,
                'data' => $user
            ]);
        }else{
            return json([
                'code' => false,
                'msg'  => '没有获取到用户信息'
            ]);
        }
    }
    public function getUserList(){
        $openid = session('openid', '', 'wechat');
        $data = ActivityUser::where('openid',$openid)->select();
        foreach ($data as $key => $value) {
            $year = strlen($value['idCard'])==15 ? ('19' . substr($value['idCard'], 6, 2)) : substr($value['idCard'], 6, 4);
            $data[$key]['age'] = date('Y') - $year;
        }
        return json($data);
    }
    public function addUser(){
        $data = request()->param();
        if(!in_array($data['type'], [0,1])) return json(['code'=>false,'msg'=>'请选择成年人或未成年人！']);
        $result = $this->validate($data,'User.add'.($data['type']?'1':'0'));
        if(true !== $result){
            return json([
                'code' => false,
                'msg'  => $result
            ]);
        }
        $data['openid'] = session('openid','','wechat');

        $result = ActivityUser::insert($data);
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
    public function editUser(){
        $data = request()->param();
        if(!in_array($data['type'], [0,1])) return json(['code'=>false,'msg'=>'请选择成年人或未成年人！']);
        $result = $this->validate($data,'User.edit'.($data['type']?'1':'0'));
        if(true !== $result){
            return json([
                'code' => false,
                'msg'  => $result
            ]);
        }
        $result = ActivityUser::update($data);
        if($result){
            return json([
                'code' => true,
                'msg'  => '修改成功！'
            ]);
        }
        return json([
            'code' => false,
            'msg'  => '修改失败！'
        ]);
    }
    public function delUser(){
        $_id = request()->param('_id');
        if(empty($_id)) return json(['code'=>false,'msg'=>'主键不能为空！']);
        $result = ActivityUser::destroy($_id);
        if($result){
            return json([
                'code' => true,
                'msg'  => '删除成功！'
            ]);
        }
        return json([
            'code' => false,
            'msg'  => '删除失败！'
        ]);
    }
    public function getMyBookeds(){
        $openid = session('openid', '', 'wechat');
        $data = request()->param();
        $map['openid'] = $openid;
        if(!empty($data['time'])){
            $map['createAt'] = ['>', $data['time']];
        }
        if(isset($data['pass'])){
            if(is_array($data['pass'])){
                $map['pass'] = ['in', $data['pass']];
            }else{
                $map['pass'] = $data['pass'];
            }
        }
        if(isset($data['visited'])){
            $map['visited'] = ['exists',$data['visited']?true:false];
        }
        $page = request()->param('page');
        $limit = request()->param('limit');
        $start = $limit * ($page - 1);
        $result = ActivityBooked::where($map)->limit($start, $limit)->order('createAt', 'desc')->select();
        if($result){
            foreach ($result as $key => $value) {
                $result[$key]['activity'] = ActivityActivity::field('title,time,address,category,type')->find($value->activity);
            }
            return json([
                'code' => true,
                'data' => $result
            ]);
        }
        return json([
            'code' => false,
            'msg'  => '没有获取到信息！'
        ]);
    }
    public function getMyBooked(){
        $openid = session('openid', '', 'wechat');
        $_id = request()->param('_id');
        if(empty($_id)) return json(['code'=>false,'msg'=>'参数有误！']);
        $result = ActivityBooked::find($_id);
        if($result){
            $result['activity'] = ActivityActivity::field('title,time,address,category,type,limit')->find($result->activity);
            return json([
                'code' => true,
                'data' => $result
            ]);
        }
        return json([
            'code' => false,
            'msg'  => '获取信息失败！'
        ]);
    }
}