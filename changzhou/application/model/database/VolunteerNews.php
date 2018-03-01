<?php
namespace app\model\database;

use think\Model;
use traits\model\SoftDelete;

class VolunteerNews extends Model{
    use SoftDelete;
    protected $table = 'volunteer_news';
    protected $createTime = 'createAt';
    protected $updateTime = 'updateAt';
    protected $autoWriteTimestamp = true;
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $deleteTime = 'deleteAt';

    protected static function base($query){
        $query->where('deleteAt','exists',false)->order('createAt','desc');
    }

    protected $type = [
        'deleteAt' => 'timestamp'
    ];
    public function getIdAttr($value){
        return (string)$value;
    }
}