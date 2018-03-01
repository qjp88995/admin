<?php
namespace app\multimedia\model;

use think\Model;
use traits\model\SoftDelete;

class Audio extends Model{
    use SoftDelete;

    protected $autoWriteTimestamp = true;
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $deleteTime = 'is_delete';

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