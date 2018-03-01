<?php
namespace app\wechat\controller;

use think\Controller;
use app\model\database\WechatUser;
use app\model\service\Wechat;

class User extends Controller{
    public function login(){
        $code = request()->param('code');
        $redirect = request()->param('redirect');
        if(empty($code)) return json([
            'code' => false,
            'msg'  => '缺少code参数'
        ]);
        $wechat = new Wechat(config('wechat'));
        // 获取用户认证的TOKEN
        $access_token = $wechat->getOauthAccessToken($code);
        if(!$access_token){
            return json([
                'code' => false,
                'msg'  => '用户认证失败！'
            ]);
        }
        $userInfo = $this->getUserInfo($access_token['openid'], false);
        if(empty($userInfo)){
            $userInfo = $this->register($access_token['access_token'], $access_token['openid']);
        }
        if(empty($userInfo)){
            return json([
                'code' => false,
                'msg'  => '获取用户信息失败！'
            ]);
        }
        foreach ($userInfo->toArray() as $key => $value) {
            session($key, $value, 'wechat');
        }
        if(!empty($redirect)){
            $this->redirect(urldecode($redirect));
        }
        return json([
            'code' => true,
            'msg'  => '登录成功！'
        ]);
    }
    public function register($access_token, $openid){
        $wechat = new Wechat(config('wechat'));
        $userinfo = $wechat->getOauthUserinfo($access_token, $openid);
        if(!$userinfo) return false;
        $userinfo['status'] = true;
        $result = WechatUser::insert($userinfo);
        if(!$result) return false;
        $user = WechatUser::where('openid', $openid)->find();
        return $user;
    }
    public function getUserInfo($openid, $isJson=true){
        $user = WechatUser::where('openid',$openid)->find();
        if($isJson){
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
        return $user;
    }
}