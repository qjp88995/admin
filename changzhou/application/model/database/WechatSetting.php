<?php
namespace app\model\database;

use think\Model;

class WechatSetting extends Model{
    protected $table = 'wechat_setting';

    public function getIdAttr($value){
        return (string)$value;
    }
}