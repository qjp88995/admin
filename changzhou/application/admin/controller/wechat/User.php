<?php
namespace app\admin\controller\wechat;

use app\admin\controller\Common;
use app\model\database\WechatUser;

class User extends Common{
    public function select(){
        if(request()->has('title') && !empty(request()->param('title'))){
            $map['nickname|openid'] = trim(request()->param('title'));
        }
        if(request()->has('createAt') && !empty(request()->param('createAt'))){
            $time = explode('/', request()->param('createAt'));
            foreach ($time as $k => $v) {
                $time[$k] = strtotime($v);
            }
            $map['createAt'] = ['between',$time];
        }
        $page = request()->param('page');
        $limit = request()->param('limit');
        $start = $limit*($page-1);
        $data = WechatUser::where(@$map)->field('content',true)->limit($start, $limit)->order('createAt','desc')->select();
        $total = WechatUser::where(@$map)->count();
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
        $data = WechatUser::find($_id);
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
        $WechatUser = new WechatUser;
        $data['createAt'] = time();
        $data['updateAt'] = time();
        $result = $WechatUser->insert($data);
        if ($result) {
            return json(['code'=>true, 'msg'=>'添加成功！']);
        }else{
            return json(['code'=>false, 'msg'=>'添加失败！']);
        }
    }
    public function update(){
        $data = request()->param();
        if (empty($data['_id'])) return json(['code'=>false, 'msg'=>'参数错误']);
        $WechatUser = new WechatUser;
        unset($data['createAt'],$data['updateAt']);
        $data['updateAt'] = time();
        $result = $WechatUser->update($data);
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
        $result = WechatUser::destroy($_id);
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