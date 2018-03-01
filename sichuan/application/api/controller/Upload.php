<?php

namespace app\api\controller;

use app\common\controller\Auth;

class Upload extends Auth{
    public function image(){
        // 文件存储路径
        $path = BASE_DIR . DS . 'uploads' . DS . 'image';
        //　文件格式
        $ext = 'jpg,png,gif,jpeg,svg';
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
                'code' => true,
                'urls' => $urls
            ]);
        }else{
            $res = $this->upload($files, $path, $ext, $size);
            if(!isset($res['code']) || $res['code']!==false){
                $res['code'] = true;
                return json($res);
            }else{
                return json($res);
            }
        }
    }
    public function audio(){
        // 文件存储路径
        $path = BASE_DIR . DS . 'uploads' . DS . 'audio';
        //　文件格式
        $ext = 'mp3';
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
            $res = $this->upload($files, $path, $ext, $size);
            if(!isset($res['code']) || $res['code']!=false){
                $res['code'] = true;
                return json($res);
            }else{
                return json($res);
            }
        }
    }
    public function video(){
        // 文件存储路径
        $path = BASE_DIR . DS . 'uploads' . DS . 'video';
        //　文件格式
        $ext = 'mp4';
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
            $res = $this->upload($files, $path, $ext, $size);
            if(!isset($res['code']) || $res['code']!=false){
                $res['code'] = true;
                return json($res);
            }else{
                return json($res);
            }
        }
    }
    public function td(){
        // 文件存储路径
        $path = BASE_DIR . DS . 'uploads' . DS . '3d';
        //　文件格式
        $ext = 'zip';
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
                'code' => true,
                'urls' => $urls
            ]);
        }else{
            $res = $this->upload($files, $path, $ext, $size);
            if(!isset($res['code']) || $res['code']!==false){
                $zip = new \ZipArchive;
                if($zip->open($res['pathname']) === TRUE){
                    $path = dirname($res['pathname']);
                    $path = $path . '/' . basename($res['filename'],'.zip');
                    if(!is_dir($path)){
                        mkdir($path);
                    }
                    $zip->extractTo($path);
                    $zip->close();
                }
                $res['code'] = true;
                $res['url'] = substr($res['url'], 0, -4);
                return json($res);
            }else{
                return json($res);
            }
        }
    }
    // 上传
    protected function upload($file, $path, $ext, $size){
        $info = $file->rule('md5')->validate(['size'=>$size,'ext'=>$ext])->move($path);
        if($info){
            $url = str_replace(BASE_DIR, '', $info->getPathName());
            return [
                'pathname' => $info->getPathName(),
                'savename' => $info->getSaveName(),
                'filename' => $info->getFilename(),
                'url' => config('website.prefix').preg_replace('/\\\/', '/', $url),
            ];
        }else{
            return [
                'code' => false,
                'msg'  => $file->getError()
            ];
        }
    }
}