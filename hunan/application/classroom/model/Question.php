<?php
namespace app\classroom\model;

use think\Model;
use traits\model\SoftDelete;

class Question extends Model{
    use SoftDelete;
    protected $table = 'exam_question';
    protected $createTime = 'createAt';
    protected $updateTime = 'updateAt';
    protected $autoWriteTimestamp = true;
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $deleteTime = 'deleteAt';

    protected static function base($query){
        $query->where('deleteAt','exists',false);
    }

    protected $type = [
        'deleteAt' => 'timestamp'
    ];

    protected $auto   = [

    ];

    protected $update = [

    ];
}