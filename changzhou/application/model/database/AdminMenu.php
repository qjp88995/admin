<?php
namespace app\model\database;

use think\Model;
use traits\model\SoftDelete;

class AdminMenu extends Model{
    use SoftDelete;
    protected $table = 'admin_menu';
    protected $createTime = 'createAt';
    protected $updateTime = 'updateAt';
    protected $autoWriteTimestamp = false;
    protected $deleteTime = 'deleteAt';

    protected static function base($query){
        $query->where('deleteAt','exists',false);
    }

    protected $type = [
        'deleteAt' => 'timestamp'
    ];

    public function getIdAttr($value){
        return (string)$value;
    }
}
