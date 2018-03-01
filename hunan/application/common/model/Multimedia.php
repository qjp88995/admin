<?php
namespace app\common\model;

use think\Model;

class Multimedia extends Model{

    protected $rootPath = ROOT_PATH . 'public' . DS;
    protected $imgPath = 'uploads/image';
    protected $audioPath = 'uploads/audio';
    protected $videoPath = 'uploads/video';

    public function dealLocalImg($file, $path = '', $use_orname = false, $thumd = true){
        $path = empty($path)?$this->imgPath:$path;
        $savePath = $this->rootPath . $path;
        if($use_orname){
            $info = $file->move($savePath, '');
        }else{
            $info = $file->move($savePath);
        }
        $original = $info->getPath() . '/' . $info->getFilename();
        if($thumd){
            $thumbnails = $info->getPath() . '/thumd.' . $info->getFilename();
            $image = \think\Image::open($original);
            $image->thumb(80, 80)->save($thumbnails);
            return ['original' => $original, 'thumbnails' => $thumbnails];
        }
        return ['original' => $original];
    }

    public function dealInterImg($url, $path = '',  $filename = '', $thumd = true){
        $path = empty($path)?$this->imgPath:$path;
        $savePath = $this->rootPath . $path;
        $type = image_type_to_mime_type(exif_imagetype($url));
        if(!empty($filename)){
            $original = $savePath . '/' . $filename;
        }else{
            $ext  = substr(strrchr($type, '/'), 1);
            $original = $savePath . '/' . date('Ymd') . '/' . md5(microtime()) . '.' . $ext;
        }
        if(!$this->checkPath(dirname($original))) return $this->error('目录创建失败！');
        $img_read_fd = fopen($url,"r");
        $img_write_fd = fopen($original,"w");
        $img_content = "";
        while(!feof($img_read_fd)){
            $img_content .= fread($img_read_fd,1024);
        }
        $rst = fwrite($img_write_fd,$img_content);
        fclose($img_read_fd);
        fclose($img_write_fd);
        if($thumd){
            if(!empty($filename)){
                $thumbnails = $savePath . '/thumd.' . basename($original);
            }else{
                $thumbnails = $savePath . '/' . date('Ymd') . '/thumd.' . basename($original);
            }
            $image = \think\Image::open($original);
            $image->thumb(80, 80)->save($thumbnails);
            return ['original' => $original, 'thumbnails' => $thumbnails];
        }
        return ['original' => $original];
    }

    public function checkImg($file){
        if(!@exif_imagetype($file)) return false;
        return true;
    }

    public function dealLocalAudio($file, $path = '', $use_orname = false){
        $path = empty($path)?$this->audioPath:$path;
        $savePath = $this->rootPath . $path;
        if($use_orname){
            $info = $file->move($savePath, '');
        }else{
            $info = $file->move($savePath);
        }
        $original = $info->getPath() . '/' . $info->getFilename();

        return ['url' => $original];
    }

    public function dealInterAudio($url, $path = '',  $filename = ''){
        $path = empty($path)?$this->audioPath:$path;
        $savePath = $this->rootPath . $path;
        if(!empty($filename)){
            $original = $savePath . '/' . $filename;
        }else{
            $original = $savePath . '/' . date('Ymd') . '/' . md5(microtime());
        }
        if(!$this->checkPath(dirname($original))) return $this->error('目录创建失败！');
        $img_read_fd = fopen($url,"r");
        $img_write_fd = fopen($original,"w");
        $img_content = "";
        while(!feof($img_read_fd)){
            $img_content .= fread($img_read_fd,1024);
        }
        $rst = fwrite($img_write_fd,$img_content);
        fclose($img_read_fd);
        fclose($img_write_fd);
        return ['url' => $original];
    }

    public function checkAudio($file){
        $mime = $file->getMime();
        return true;
    }

    public function dealLocalVideo($file, $path = '', $use_orname = false){
        $path = empty($path)?$this->videoPath:$path;
        $savePath = $this->rootPath . $path;
        if($use_orname){
            $info = $file->move($savePath, '');
        }else{
            $info = $file->move($savePath);
        }
        $original = $info->getPath() . '/' . $info->getFilename();

        return ['url' => $original];
    }

    public function dealInterVideo($url, $path = '',  $filename = ''){
        $path = empty($path)?$this->videoPath:$path;
        $savePath = $this->rootPath . $path;
        if(!empty($filename)){
            $original = $savePath . '/' . $filename;
        }else{
            $original = $savePath . '/' . date('Ymd') . '/' . md5(microtime());
        }
        if(!$this->checkPath(dirname($original))) return $this->error('目录创建失败！');
        $img_read_fd = fopen($url,"r");
        $img_write_fd = fopen($original,"w");
        $img_content = "";
        while(!feof($img_read_fd)){
            $img_content .= fread($img_read_fd,1024);
        }
        $rst = fwrite($img_write_fd,$img_content);
        fclose($img_read_fd);
        fclose($img_write_fd);
        return ['url' => $original];
    }

    public function checkVideo($file){
        $mime = $file->getMime();
        return true;
    }

    protected function checkPath($path){
        if (is_dir($path)) {
            return true;
        }

        if (mkdir($path, 0755, true)) {
            return true;
        } else {
            $this->error = "目录 {$path} 创建失败！";
            return false;
        }
    }
}