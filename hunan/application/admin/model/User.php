<?php
namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

class User extends Model{
    use SoftDelete;
    protected $table = 'admin_user';
    protected $createTime = 'createAt';
    protected $updateTime = 'updateAt';
    protected $autoWriteTimestamp = true;
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $deleteTime = 'deleteAt';

    protected static function base($query){
        $query->where('deleteAt',0);
    }
    protected static function init(){
        User::beforeInsert(function($user){
            $user->reg_ip = request()->ip();
        });
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