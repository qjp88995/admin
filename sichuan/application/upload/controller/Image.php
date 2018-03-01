<?php
namespace app\upload\controller;
use app\common\controller\Auth;
use app\upload\model\Image as Img;

class Image extends Auth{
    public function index(){
        if(!empty(request()->param('path$'))){
            $path = request()->param('path$');
            $pathinfo = pathinfo(config('upload.image_path'). DS . $path);
            if(!file_exists($pathinfo['dirname'])){
                return json('请求的资源目录不存在',404);
            }
            $fileInfo = explode('-', $pathinfo['filename']);
            $filename = current($fileInfo);
            $ext = $pathinfo['extension'];
            $file = $pathinfo['dirname'] . DS . $filename . '.' . $ext;
            if(!file_exists($file)){
                return json('请求的资源文件不存在',404);
            }
            // c=>裁剪,t=>缩略图,f=>翻转,r=>旋转
            $param = explode('_', end($fileInfo));
            switch ($param[0]) {
                case 'c':
                    $w = $param[1]?$param[1]:50;
                    $h = $param[2]?$param[2]:50;
                    $x = $param[3]?$param[3]:0;
                    $y = $param[4]?$param[4]:0;
                    $str = implode('_', ['c',$w,$h,$x,$y]);
                    $newFilename = $pathinfo['dirname'].DS.$filename.'-'.$str.'.'.$ext;
                    if(!file_exists($newFilename)){
                        $image = \think\Image::open($file);
                        $image->crop($w, $h, $x, $y)->save($newFilename);
                    }
                    break;
                case 't':
                    $w = $param[1]?$param[1]:50;
                    $h = $param[2]?$param[2]:50;
                    $type = $param[3]?$param[3]:1;
                    $str = implode('_', ['t',$w,$h,$type]);
                    $newFilename = $pathinfo['dirname'].DS.$filename.'-'.$str.'.'.$ext;
                    if(!file_exists($newFilename)){
                        $image = \think\Image::open($file);
                        $image->thumb($w, $h, $type)->save($newFilename);
                    }
                    break;
                case 'f':
                    $type = $param[3]?$param[3]:1;
                    $str = implode('_', ['f',$type]);
                    $newFilename = $pathinfo['dirname'].DS.$filename.'-'.$str.'.'.$ext;
                    if(!file_exists($newFilename)){
                        $image = \think\Image::open($file);
                        $image->flip($type)->save($newFilename);
                    }
                    break;
                case 'r':
                    $degrees = $param[1]?$param[1]:90;
                    $str = implode('_', ['r',$degrees]);
                    $newFilename = $pathinfo['dirname'].DS.$filename.'-'.$str.'.'.$ext;
                    if(!file_exists($newFilename)){
                        $image = \think\Image::open($file);
                        $image->rotate($degrees)->save($newFilename);
                    }
                    break;
                default:
                    return json('异常错误',500);
                    break;
            }
            $url = str_replace(BASE_DIR,'',$newFilename);
            $this->redirect($url);
        }else{
            return json('请求的资源不存在',404);
        }
    }
}