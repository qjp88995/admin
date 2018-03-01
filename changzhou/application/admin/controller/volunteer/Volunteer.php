<?php
namespace app\admin\controller\volunteer;

use app\admin\controller\Common;
use app\model\database\VolunteerVolunteer;

class Volunteer extends Common{
    public function select(){
        if(request()->has('title') && !empty(request()->param('title'))){
            $map['name|idCard'] = trim(request()->param('title'));
        }
        if(request()->has('createAt') && !empty(request()->param('createAt'))){
            $time = explode('/', request()->param('createAt'));
            foreach ($time as $k => $v) {
                $time[$k] = strtotime($v);
            }
            $map['createAt'] = ['between',$time];
        }
        if(request()->has('level') && !empty(request()->param()['level'])){
            $level = request()->param()['level'];
            $map['level'] = $level;
        }
        $page = request()->param('page');
        $limit = request()->param('limit');
        $start = $limit*($page-1);
        $data = VolunteerVolunteer::where(@$map)->field('content',true)->limit($start, $limit)->order('createAt','desc')->select();
        $total = VolunteerVolunteer::where(@$map)->count();
        return json([
            'code'  => true,
            'total' => $total,
            'data'  => $data
        ]);
    }
    public function find(){
        $_id = request()->param('_id');
        if(empty($_id)) return json([
            'code' => false,
            'msg'  => '参数错误！'
        ]);
        $data = VolunteerVolunteer::find($_id);
        if($data){
            return json([
                'code' => true,
                'data' => $data
            ]);
        }
        return json([
            'code' => false,
            'msg'  => '没有找到结果！'
        ]);
    }

    public function insert(){
        $data = request()->param();
        if (!empty($data['_id'])) return json(['code'=>false, 'msg'=>'参数错误']);
        $VolunteerVolunteer = new VolunteerVolunteer;
        $data['createAt'] = time();
        $data['updateAt'] = time();
        $result = $VolunteerVolunteer->insert($data);
        if ($result) {
            return json(['code'=>true, 'msg'=>'添加成功！']);
        }else{
            return json(['code'=>false, 'msg'=>'添加失败！']);
        }
    }
    public function update(){
        $data = request()->param();
        if (empty($data['_id'])) return json(['code'=>false, 'msg'=>'参数错误']);
        $VolunteerVolunteer = new VolunteerVolunteer;
        unset($data['createAt'],$data['updateAt']);
        $data['updateAt'] = time();
        $result = $VolunteerVolunteer->update($data);
        if ($result) {
            return json(['code'=>true, 'msg'=>'修改成功！']);
        }else{
            return json(['code'=>false, 'msg'=>'修改失败！']);
        }
    }

    public function delete(){
        if (empty(request()->param()['_id'])) return json([
                'code' => false,
                'msg'  => '非法参数！'
            ]);
        $_id = request()->param()['_id'];
        $result = VolunteerVolunteer::destroy($_id);
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
}