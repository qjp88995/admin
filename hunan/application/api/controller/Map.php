<?php

namespace app\api\controller;

use app\common\controller\Auth;
use app\api\model\Txmap;

class Map extends Auth{
    public function getAreas(){
        $id = intval(request()->param('id'));
        $map = new Txmap;
        $list = $map->getchildren($id);
        $list = json_decode($list,true);
        return $list['result'][0];
    }
    public function getPro(){
        $id = intval(request()->param('id'));
        $map = new Txmap;
        $list = $map->getchildren($id);
        $list = json_decode($list,true);
        return $list['result'][0];
    }
}