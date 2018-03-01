<?php
namespace app\wechat\controller;

use \think\Controller;
use app\wechat\model\Wechat;

class Index extends Controller{
    /**
     * log overwrite
     * @see Wechat::log()
     */
    protected $options = array(
          'token'=>'bowuguan', //填写你设定的key
          //'encodingaeskey'=>'encodingaeskey', //填写加密用的EncodingAESKey
          'appid'=>'wxa11c0c899b692db0', //填写高级调用功能的app id
          'appsecret'=>'e14efd9d18be6483b62f30103f0f561b' //填写高级调用功能的密钥
    );
    public function index(){
        $wechat = new Wechat($this->options);
        $menu = $wechat->getForeverList('news',0,20);
        return json($menu);
    }
    protected function log($log){
        if ($this->debug) {
            if (function_exists($this->logcallback)) {
                if (is_array($log)) $log = print_r($log,true);
                return call_user_func($this->logcallback,$log);
            }elseif (class_exists('Log')) {
                Log::write('wechat：'.$log, Log::DEBUG);
                return true;
            }
        }
        return false;
    }

    /**
     * 重载设置缓存
     * @param string $cachename
     * @param mixed $value
     * @param int $expired
     * @return boolean
     */
    protected function setCache($cachename,$value,$expired){
        return S($cachename,$value,$expired);
    }

    /**
     * 重载获取缓存
     * @param string $cachename
     * @return mixed
     */
    protected function getCache($cachename){
        return S($cachename);
    }

    /**
     * 重载清除缓存
     * @param string $cachename
     * @return boolean
     */
    protected function removeCache($cachename){
        return S($cachename,null);
    }

}