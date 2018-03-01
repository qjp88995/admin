<?php
namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

class Group extends Model{
    use SoftDelete;
    protected $table = 'admin_group';
    protected $deleteTime = 'deleteAt';

    protected static function base($query){
        $query->where('deleteAt',0);
    }

    protected $type = [
        'deleteAt' => 'timestamp'
    ];

    protected $auto   = [

    ];

    protected $insert = [
        'deleteAt' => 0
    ];

    protected $update = [

    ];
}
