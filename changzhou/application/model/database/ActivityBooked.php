<?php
namespace app\model\database;

use think\Model;

class ActivityBooked extends Model{
    protected $table = 'activity_booked';
    protected $createTime = 'createAt';
    protected $updateTime = 'updateAt';
    protected $autoWriteTimestamp = true;
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $type = [
        'deleteAt' => 'timestamp'
    ];
    public function getIdAttr($value){
        return (string)$value;
    }
}