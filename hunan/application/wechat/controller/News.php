<?php
namespace app\wechat\controller;

use \think\Controller;
use app\wechat\model\Wechat;

class News extends Controller{
    /**
     * log overwrite
     * @see Wechat::log()
     */
    protected $type = 'news';
    protected $options = array(
          'token'=>'bowuguan', //填写你设定的key
          //'encodingaeskey'=>'encodingaeskey', //填写加密用的EncodingAESKey
          'appid'=>'wxa11c0c899b692db0', //填写高级调用功能的app id
          'appsecret'=>'e14efd9d18be6483b62f30103f0f561b', //填写高级调用功能的密钥
          'debug'=>true
    );
    public function index(){
        $wechat = new Wechat($this->options);
        $page   = request()->has('page')?request()->param('page'):1;
        $limit  = request()->has('limit')?request()->param('limit'):20;
        $start  = $limit*($page-1);
        $news   = $wechat->getForeverList('news',$start,$limit);
        if(!$news){
          return json($wechat->errMsg);
        }
        return json($news);
    }
}