<?php
namespace app\wechat\controller;

use think\Controller;
use app\model\service\Wechat;

class Oauth extends Controller{
    protected $wechat;
    public function _initialize(){
        $this->wechat = new Wechat(config('wechat'));
    }
    // 获取access_token
    public function getAccessToken(){
        $token = $this->wechat->checkAuth();
        if($token){
            return json([
                'code'  => true,
                'access_token' => $token
            ]);
        }
        return json([
            'code' => false,
            'msg'  => '获取失败！'
        ]);
    }
    // 获取重定向地址
    public function getOauthRedirect(){
        $args = request()->only('redirect,state');
        if(empty($args['redirect'])) return json([
            'code' => false,
            'msg'  => '缺少redirect参数'
        ]);
        $callback = $args['redirect'];
        $state = !empty($args['state'])?$args['state']:'state';
        $uri = $this->wechat->getOauthRedirect($callback, $state);
        return json([
            'code' => true,
            'uri'  => $uri
        ]);
    }
    // 通过code获取Access Token
    public function getOauthAccessToken(){
        $code = request()->param('code');
        $redirect = request()->param('redirect');
        if(empty($code)) return json([
            'code' => false,
            'msg'  => '缺少code参数'
        ]);
        $data = $this->wechat->getOauthAccessToken($code);
        if($data){
            return json([
                'code' => true,
                'data' => $data
            ]);
        }
        return json([
            'code' => false,
            'msg'  => '获取失败！'
        ]);
    }
    // 刷新access token并续期
    public function getOauthRefreshToken(){
        $refresh_token = request()->param('refresh_token');
        if(empry($refresh_token)) return json([
            'code' => false,
            'msg'  => '缺少refresh_token参数'
        ]);
        $data = $this->wechat->getOauthRefreshToken($refresh_token);
        if($data){
            return json([
                'code' => true,
                'data' => $data
            ]);
        }
    }
    // 获取授权后的用户资料
    public function getOauthUserinfo(){
        $args = request()->only('access_token,openid');
        if(empty($args['access_token']) || empty($args['openid'])){
            return json([
                'code' => false,
                'msg'  => '缺少access_token或openid参数'
            ]);
        }
        $data = $this->wechat->getOauthUserinfo($args['access_token'], $args['openid']);
        if($data){
            return json([
                'code' => true,
                'data' => $data
            ]);
        }
        return json([
            'code' => false,
            'msg'  => '获取信息失败！'
        ]);
    }
    // 检验授权凭证是否有效
    public function getOauthAuth(){
        $args = request()->only('access_token,openid');
        if(empty($args['access_token']) || empty($args['openid'])){
            return json([
                'code' => false,
                'msg'  => '缺少access_token或openid参数'
            ]);
        }
        $data = $this->wechat->getOauthAuth($args['access_token'], $args['openid']);
        if($data){
            return json([
                'code' => true,
                'msg'  => '有效'
            ]);
        }else{
            return json([
                'code' => false,
                'msg'  => '失效'
            ]);
        }
    }
}