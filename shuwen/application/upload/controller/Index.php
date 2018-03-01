<?php
namespace app\api\controller;

use app\upload\controller\Auth;

class Index extends Auth{
    public function image(){
        // 文件存储路径
        $path = BASE_DIR . DS . 'uploads' . DS . 'image';
        //　文件格式
        $ext = 'jpg,png,gif';
        //　文件大小
        $size = 4096*1024;
        $files = request()->file('file');
        if(empty($files)) return json(false);
        if(is_array($files)){
            foreach($files as $file){
                $this->upload($file, $path, $ext, $size);
            }
        }else{
            $info = $this->upload($files, $path, $ext, $size);
            if($info['code']){
                // 该文件是否存在
                $exit = Files::where('hash_md5',$info['msg']['hash_md5'])->find();
                //　如果存在则删除这个文件，返回查询到的信息
                if($exit){
                    unlink($info['msg']['pathname']);
                    return json([
                        'url' => $exit['relapath']
                    ]);
                // 不存在则把文件信息存储下来
                }else{
                    $this->saveDb($info['msg']);
                    return json([
                        'url' => $info['msg']['relapath']
                    ]);
                }
            }else{
                return json([
                    'code' => false,
                    'msg'  => $info['msg']
                ]);
            }
        }
    }
    // 上传
    protected function upload($file, $path, $ext, $size){
        $info = $file->validate(['size'=>$size,'ext'=>$ext])->move($path);
        if($info){
            return [
                'code' => true,
                'msg'  => [
                    'ext'       => $info->getExtension(), //　文件后缀
                    'savename'  => $info->getSaveName(),  // 文件存储名称
                    'filename'  => $info->getFilename(),  // 文件一级目录＋名称
                    'pathname'  => $info->getPathName(),  //　文件绝对路径
                    'relapath'  => str_replace(BASE_DIR, '', $info->getPathName()),  // 文件相对网站路径
                    'hash_md5'  => $info->hash('md5'),  // 文件md5哈希散列
                    'hash_sha1' => $info->hash('sha1')  // 文件sha1哈希散列
                ]
            ];
        }else{
            return [
                'code' => false,
                'msg'  => $file->getError()
            ];
        }
    }
    public function audio(){
        // 文件存储路径
        $path = BASE_DIR . DS . 'uploads' . DS . 'audio';
        //　文件格式
        // $ext = 'jpg,png,gif';
        //　文件大小
        // $size = 4096*1024;
        $files = request()->file('file');
        if(empty($files)) return json(false);
        if(is_array($files)){
            foreach($files as $file){
                $this->upload($file, $path, @$ext, @$size);
            }
        }else{
            $info = $this->upload($files, $path, @$ext, @$size);
            if($info['code']){
                // 该文件是否存在
                $exit = Files::where('hash_md5',$info['msg']['hash_md5'])->find();
                //　如果存在则删除这个文件，返回查询到的信息
                if($exit){
                    unlink($info['msg']['pathname']);
                    return json([
                        'url' => $exit['relapath']
                    ]);
                // 不存在则把文件信息存储下来
                }else{
                    $this->saveDb($info['msg']);
                    return json([
                        'url' => $info['msg']['relapath']
                    ]);
                }
            }else{
                return json([
                    'code' => false,
                    'msg'  => $info['msg']
                ]);
            }
        }
    }
}