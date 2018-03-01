<?php
namespace app\model\database;

use think\Model;

class ActivityUser extends Model{
    protected $table = 'activity_user';
    protected $createTime = 'createAt';
    protected $updateTime = 'updateAt';
    protected $autoWriteTimestamp = true;
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $deleteTime = 'deleteAt';

    protected $type = [
        'deleteAt' => 'timestamp'
    ];
    public function getIdAttr($value){
        return (string)$value;
    }
}