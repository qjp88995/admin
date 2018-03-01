<?php
namespace app\model\database;

use think\Model;

class VolunteerMessage extends Model{
    protected $table = 'volunteer_message';
    protected $createTime = 'createAt';
    protected $updateTime = 'updateAt';
    protected $autoWriteTimestamp = true;
    // protected $dateFormat = 'Y-m-d H:i:s';

    public function getIdAttr($value){
        return (string)$value;
    }
}