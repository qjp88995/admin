<?php
namespace app\article\model;

use think\Model;
use traits\model\SoftDelete;

class Cate extends Model{
    use SoftDelete;
    protected $createTime = 'createAt';
    protected $updateTime = 'updateAt';
    protected $table = 'article_category';
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