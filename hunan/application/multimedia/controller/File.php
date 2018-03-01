<?php
namespace app\multimedia\controller;

use app\common\controller\Auth;
use app\api\model\Files;

class File extends Auth{
    protected $rootPath = APP_PATH . '../uploads/';
    protected $path;
    protected $rootFolder = ['image', 'audio', 'video'];
    public function _initialize(){
        foreach ($this->rootFolder as $value) {
            $dir = $this->rootPath . $value;
            if(!is_dir($dir)){
                mkdir($dir, 0777, true);
            }
        }
    }
    public function index(){
        $command = request()->param('command');
        $type = request()->param('type');
        $currentFolder = request()->param('currentFolder');
        if(strpos($currentFolder, '..')) return false;
        if(!in_array($type, ['files', 'folders', 'all'])) return false;
        $this->path = rtrim($this->rootPath . trim($currentFolder,'/'), '/') . '/';
        switch ($command) {
            case 'getFolders':
                return $this->getFolders();
                break;
            case 'getFiles':
                return $this->getFiles();
                break;
            // case 'renameFolder':
            //     return $this->renameFolder();
            //     break;
            // case 'renameFile':
            //     if(empty(request()->param('fileName')) || empty(request()->param('newFileName'))) return false;
            //     return $this->renameFile();
            //     break;
            case 'createFolder':
                return $this->createFolder();
                break;
            case 'fileUpload':
                return $this->fileUpload();
                break;
            case 'deleteFolder':
                if(in_array($currentFolder, $this->rootFolder)){
                    return false;
                }
                return $this->deleteFolder($this->path);
                break;
            case 'deleteFiles':
                if(empty(request()->param('fileName'))) return false;
                return $this->deleteFiles();
                break;
            default:
                return false;
                break;
        }
    }
    // 获取上传进度
    public function getProgress(){
        $key = ini_get("session.upload_progress.prefix") . $_POST[ini_get("session.upload_progress.name")];
        if (!empty($_SESSION[$key])) {
            $current = $_SESSION[$key]["bytes_processed"];
            $total = $_SESSION[$key]["content_length"];
            return $current < $total ? ceil($current / $total * 100) : 100;
        }else{
            return 100;
        }
    }
    // 获取文件夹
    protected function getFolders(){
        return $this->traverse('folders', $this->path);
    }
    // 获取文件
    protected function getFiles(){
        return $this->traverse('files', $this->path);
    }
    // 重命名文件夹
    protected function renameFolder(){
        $newFolderName = request()->param('newFolderName');
        if(empty($newFolderName)) return false;
        $arr = explode('/', $this->path);
        $arr[count($arr)-2] = $newFolderName;
        $newPath = implode('/', $arr);
        return rename($this->path,$newPath);
    }
    // 重命名文件
    protected function renameFile(){
        $filename = $this->path . request()->param('fileName');
        $newfileName = $this->path . request()->param('newFileName');
        return rename($filename,$newfileName);
    }
    // 创建文件夹
    protected function createFolder(){
        $newFolderName = request()->param('newFolderName');
        if(empty($newFolderName)) return false;
        $path = $this->path . $newFolderName;
        return mkdir($path);
    }
    // 文件上传
    protected function fileUpload(){
        $file = request()->file('file');
        $info = $file->move($this->path,'',false);
        if($info){
            $F = new Files;
            $F->save([
                'ext'       => $info->getExtension(), //　文件后缀
                'savename'  => $info->getSaveName(),  // 文件存储名称
                'filename'  => $info->getFilename(),  // 文件一级目录＋名称
                'pathname'  => $info->getPathName(),  //　文件绝对路径
                'relapath'  => str_replace(APP_PATH . '..', '', $info->getPathName()),  // 文件相对网站路径
                'hash_md5'  => $info->hash('md5'),  // 文件md5哈希散列
                'hash_sha1' => $info->hash('sha1')  // 文件sha1哈希散列
            ]);
            return true;
        }else{
            return false;
        }
    }
    // 删除文件夹
    protected function deleteFolder($directory){
        if(file_exists($directory)){//判断目录是否存在，如果不存在rmdir()函数会出错
            if($dir_handle=@opendir($directory)){//打开目录返回目录资源，并判断是否成功
                while($filename=readdir($dir_handle)){//遍历目录，读出目录中的文件或文件夹
                    if($filename!='.' && $filename!='..'){//一定要排除两个特殊的目录
                        $subFile=$directory.$filename;//将目录下的文件与当前目录相连
                        if(is_dir($subFile)){//如果是目录条件则成了
                            $this->deleteFolder($subFile . '/');//递归调用自己删除子目录
                        }
                        if(is_file($subFile)){//如果是文件条件则成立
                            $hash_md5 = hash_file('md5', $subFile);
                            Files::where('hash_md5', $hash_md5)->delete();
                            unlink($subFile);//直接删除这个文件
                        }
                    }
                }
                closedir($dir_handle);//关闭目录资源
                return rmdir($directory);//删除空目录
            }
        }else{
            return false;
        }
    }
    // 删除文件
    protected function deleteFiles(){
        $filename = $this->path . request()->param('fileName');
        $hash_md5 = hash_file('md5', $filename);
        Files::where('hash_md5', $hash_md5)->delete();
        return unlink($filename);
    }

    // 遍历文件
    protected function traverse($type, $path){
        $dir = false;
        $both = false;
        switch ($type) {
            case 'files':
                $dir = false;
                break;
            case 'folders':
                $dir = true;
                break;
            case 'all':
                $both = true;
                break;
            default:
                return false;
                break;
        }
        $data = [];
        if (is_dir($path)) {
            if ($dh = opendir($path)) {
                while (($file = readdir($dh)) !== false) {
                    if($both || ($dir && is_dir("{$path}{$file}")) || (!$dir && !is_dir("{$path}{$file}"))){
                        if(!($file == '.' || $file == '..')){
                            $f_path = $path."{$file}";
                            if(is_dir($f_path)){
                                $current = str_replace($this->rootPath, '', $f_path);
                                $arr = [
                                    'title'    => $file,
                                    'name'    => $file,
                                    'current'  => $current,
                                    'children' => $this->traverse($type, $f_path . '/')
                                ];
                            }else{
                                $url = str_replace(APP_PATH . '..', '', $f_path);
                                $arr = [
                                    'title' => $file,
                                    'name'    => $file,
                                    'url'   => config('website')['domain'].$url,
                                    'info'  => $this->getFileInfo($f_path)
                                ];
                            }
                            array_push($data, $arr);
                        }
                    }
                }
                closedir($dh);
                return $data;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    // 获取文件信息
    protected function getFileInfo($filePath){
        $file  = fopen($filePath, "r");
        $info  = fstat($file);
        $units = array(' B', ' KB', ' MB', ' GB', ' TB');
        for ($i = 0; $info['size'] >= 1024 && $i < 4; $i++) $info['size'] /= 1024;
        return [
            'type'  => mime_content_type($filePath),
            'size'  => round($info['size'], 2).$units[$i],
            'ctime' => date('Y-m-d H:i:s', $info['ctime'])
        ];
        fclose($file);
    }

}