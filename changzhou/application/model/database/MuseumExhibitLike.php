<?php
namespace app\model\database;

use think\Model;

class MuseumExhibitLike extends Model{
    protected $table = 'museum_exhibit_like';
    protected $createTime = 'createAt';
    protected $updateTime = 'updateAt';
    protected $autoWriteTimestamp = true;
    protected $dateFormat = 'Y-m-d H:i:s';

    public function getIdAttr($value){
        return (string)$value;
    }
}