<?php
namespace app\volunteer\controller;

use app\volunteer\controller\Common;
use app\model\database\VolunteerVolunteer;
use app\model\database\VolunteerService;
use app\model\database\VolunteerBooked;

class Volunteer extends Common{
    public function register(){
        $data = request()->param();
        $result = $this->validate($data,'Volunteer');
        if(true !== $result){
            return json([
                'code' => false,
                'msg'  => $result
            ]);
        }
        $findIdCard = VolunteerVolunteer::where('idCard',$data['idCard'])->find();
        if($findIdCard){
            return json([
                'code' => false,
                'msg'  => '身份证信息已被注册！'
            ]);
        }
        $data['status'] = true;
        $data['level'] = 'apply';
        $data['notic'] = '您的资料正在审核中，审核通过会以电话方式通知';
        $data['createAt'] = time();
        $data['updateAt'] = time();
        $res = VolunteerVolunteer::insert($data);
        if($res){
            $info = VolunteerVolunteer::where('idCard', $data['idCard'])->find();
            foreach ($info->toArray() as $key => $value) {
                session($key, $value, 'volunteer');
            }
            return json([
                'code' => true,
                'msg'  => '注册成功'
            ]);
        }else{
            return json([
                'code' => false,
                'msg'  => '注册失败，服务器内部异常'
            ]);
        }
    }
    public function editData(){
        $data = request()->except([
            '_id', 'name', 'idCard',
            'createAt', 'updateAt',
            'expiration', 'statistics', 'status'
        ]);
        $result = $this->validate($data,'Volunteer.edit');
        if(true !== $result){
            return json([
                'code' => false,
                'msg'  => $result
            ]);
        }
        $data['_id'] = session('_id', '', 'volunteer');
        $info = VolunteerVolunteer::find($data['_id']);
        if($info && $info->level==='eliminate') $data['level'] = 'apply';
        $result = VolunteerVolunteer::update($data);
        if($result){
            return json([
                'code' => true,
                'msg' => '修改成功！'
            ]);
        }
        return json([
            'code' => false,
            'msg' => '修改失败！'
        ]);
    }
    public function login(){
        $data = request()->param();
        $result = $this->validate($data,[
            'idCard' => 'require',
            'name'   => 'require'
        ],[
            'idCard.require' => '身份证不能为空！',
            'name'           => '姓名不能为空！'
        ]);
        if(true !== $result){
            return json([
                'code' => false,
                'msg'  => $result
            ]);
        }
        $info = VolunteerVolunteer::where([
            'idCard' => $data['idCard'],
            'name'   => $data['name']
        ])->find();
        if($info){
            foreach ($info->toArray() as $key => $value) {
                session($key, $value, 'volunteer');
            }
            return json([
                'code' => true,
                'msg'  => '登录成功！',
                'level' => $info->level
            ]);
        }
        return json([
            'code' => false,
            'msg'  => '登录失败！'
        ]);
    }
    public function logout(){
        session(null,'','volunteer');
        return json([
            'code' => true,
            'msg'  => '退出成功！'
        ]);
    }
    public function getMyInfo(){
        $result = VolunteerVolunteer::field('createAt,expiration,statistics,status,updateAt', true)->find(session('_id','','volunteer'));
        if($result){
            return json([
                'code' => true,
                'data'  => $result
            ]);
        }
        return json([
            'code' => false,
            'msg'  => '获取个人信息失败'
        ]);
    }
    public function getMyBooked(){
        $_id = session('_id', '', 'volunteer');
        $data = request()->param();
        $map['volunteer'] = $_id;
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
        // 不显示已经取消的
        $map['status'] = true;
        $page = request()->param('page');
        $limit = request()->param('limit');
        $start = $limit * ($page - 1);
        $result = VolunteerBooked::where($map)->limit($start, $limit)->order('createAt', 'desc')->select();
        if($result){
            foreach ($result as $key => $value) {
                $result[$key]['service'] = VolunteerService::field('title,time')->find($value->service);
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
}