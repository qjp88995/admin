<?php

namespace app\api\controller;

use think\Controller;

class Field extends Controller{
    public function setting(){
        return $this->fetch('public@field:setting');
    }
}