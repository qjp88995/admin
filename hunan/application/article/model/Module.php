<?php
namespace app\article\model;

use think\Model;
use traits\model\SoftDelete;
class Module extends Model{
    use SoftDelete;
    protected $table = 'article_module';
    protected $autoWriteTimestamp = true;
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $deleteTime = 'deleteAt';

    protected static function base($query){
        $query->where('is_delete',0);
    }

    protected $type = [

    ];

    protected $auto   = [

    ];

    protected $insert = [
        'is_delete' => 0
    ];

    protected $update = [

    ];
}