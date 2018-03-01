<?php
namespace app\upload\model;
use think\Model;

class Image extends Model{
    public function crop($filename, $newFilename, $w, $h, $x=0, $y=0){
        $image = \think\Image::open($filename);
        $image->crop($w, $h, $x, $y)->save($newFilename);
        return $newFilename;
    }
    /*
        //常量，标识缩略图等比例缩放类型
        const THUMB_SCALING   = 1;
        //常量，标识缩略图缩放后填充类型
        const THUMB_FILLED    = 2;
        //常量，标识缩略图居中裁剪类型
        const THUMB_CENTER    = 3;
        //常量，标识缩略图左上角裁剪类型
        const THUMB_NORTHWEST = 4;
        //常量，标识缩略图右下角裁剪类型
        const THUMB_SOUTHEAST = 5;
        //常量，标识缩略图固定尺寸缩放类型
        const THUMB_FIXED     = 6;
    */
    public function thumb($filename, $newFilename, $w, $h, $type=1){
        $image = \think\Image::open($filename);
        $image->thumb($w, $h, $type)->save($newFilename);
        return $newFilename;
    }
    public function flip($filename, $newFilename, $type){
        $image = \think\Image::open('./image.png');
    }
    public function rotate($filename, $newFilename, ){

    }
}