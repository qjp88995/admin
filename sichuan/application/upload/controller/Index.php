<?php
namespace app\upload\controller;

use app\common\controller\Auth;

class Index extends Auth{
    public function index(){
        dump(request()->param());
        return '<form action="/upload/image/upload" method="post" enctype="multipart/form-data"><input type="file" name="file"><input type="submit"></form>';
    }
}