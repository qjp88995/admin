<?php

namespace app\api\controller;

use app\common\controller\Auth;

class Upload extends Auth{
    public function image(){
        // 文件存储路径
        $path = BASE_DIR . DS . 'uploads' . DS . 'image';
        //　文件格式
        $ext = 'jpg,png,gif';
        //　文件大小
        $size = 4096*1024;
        $files = request()->file('file');
        if(empty($files)) return json([
                    'code' => false,
                    'msg'  => '请添加文件!'
        ]);
        if(is_array($files)){
            $urls = [];
            foreach($files as $file){
                array_push($urls, $this->upload($file, $path, $ext, $size));
            }
            return json([
                'urls' => $urls
            ]);
        }else{
            $url = $this->upload($files, $path, $ext, $size);
            if(!isset($url['code']) || $url['code']!==false){
                return json([
                    'url' => $url
                ]);
            }else{
                return json($url);
            }
        }
    }
    // 上传
    protected function upload($file, $path, $ext, $size){
        $info = $file->rule('md5')->validate(['size'=>$size,'ext'=>$ext])->move($path);
        if($info){
            $url = str_replace(BASE_DIR, '', $info->getPathName());
            return config('website.prefix').preg_replace('/\\\/', '/', $url);
        }else{
            return [
                'code' => false,
                'msg'  => $file->getError()
            ];
        }
    }
    // 生成缩略图
    protected function thumd($path, $original, $w, $h){
        $image = \think\Image::open($path . DS . $original);
        $width = $image->width();
        $height = $image->height();
        $type = $image->type();
        $mime = $image->mime();
        $image->thumd($w, $h)->save($path . DS . $savename);
    }
    // 将文件信息存放在数据库
    protected function saveDb($info){
        $F = new Files;
        $F->save($info);
    }
    public function audio(){
        // 文件存储路径
        $path = BASE_DIR . DS . 'uploads' . DS . 'audio';
        //　文件格式
        $ext = 'mp3,wav';
        //　文件大小
        $size = null;
        $files = request()->file('file');
        if(empty($files)) return json(false);
        if(is_array($files)){
            $urls = [];
            foreach($files as $file){
                array_push($urls, $this->upload($file, $path, $ext, $size));
            }
            return json([
                'urls' => $urls
            ]);
        }else{
            $url = $this->upload($files, $path, $ext, $size);
            if(!isset($url['code']) || $url['code']!=false){
                return json([
                    'url' => $url
                ]);
            }else{
                return json($url);
            }
        }
    }
}