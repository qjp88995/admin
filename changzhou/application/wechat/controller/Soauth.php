<?php
namespace app\wechat\controller;

use think\Controller;
use app\model\service\Wechat;

class Soauth extends Controller{
    protected $wechat;
    public function _initialize(){
        $this->wechat = new Wechat(config('swechat'));
    }
    public function getSessionKey(){
        $code = request()->param('code');
        if(empty($code)) return json([
            'code' => false,
            'msg'  => '缺少code参数'
        ]);
        $data = $this->wechat->getSessionKey($code);
        if($data){
            return json([
                'code' => true,
                'openid' => $data['openid']
            ]);
        }
        return json([
            'code' => false,
            'msg'  => '获取失败！'
        ]);
    }
}