<?php
namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

class Authority extends Model{
    use SoftDelete;
    protected $table = 'admin_authority';
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