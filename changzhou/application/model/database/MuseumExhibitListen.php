<?php
namespace app\model\database;

use think\Model;

class MuseumExhibitListen extends Model{
    protected $table = 'museum_exhibit_listen';
    protected $createTime = 'createAt';
    protected $updateTime = 'updateAt';
    protected $autoWriteTimestamp = true;
    protected $dateFormat = 'Y-m-d H:i:s';

    public function getIdAttr($value){
        return (string)$value;
    }
}