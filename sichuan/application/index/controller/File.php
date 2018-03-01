<?php
namespace app\index\controller;

use app\common\controller\Auth;

class File extends Auth{
    protected $rootPath = ROOT_PATH . 'public/uploads/';
    protected $path;
    protected $rootFolder = ['image', 'audio', 'video'];
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
            case 'renameFolder':
                return $this->renameFolder();
                break;
            case 'renameFile':
                if(empty(request()->param('fileName')) || empty(request()->param('newFileName'))) return false;
                return $this->renameFile();
                break;
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
    protected function getFolders(){
        return $this->traverse('folders', $this->path);
    }

    protected function getFiles(){
        return $this->traverse('files', $this->path);
    }

    protected function renameFolder(){
        $newFolderName = request()->param('newFolderName');
        if(empty($newFolderName)) return false;
        $arr = explode('/', $this->path);
        $arr[count($arr)-2] = $newFolderName;
        $newPath = implode('/', $arr);
        return rename($this->path,$newPath);
    }

    protected function renameFile(){
        $filename = $this->path . request()->param('fileName');
        $newfileName = $this->path . request()->param('newFileName');
        return rename($filename,$newfileName);
    }

    protected function createFolder(){
        $newFolderName = request()->param('newFolderName');
        if(empty($newFolderName)) return false;
        $path = $this->path . $newFolderName;
        return mkdir($path);
    }

    protected function fileUpload(){
        $file = request()->file('file');
        $info = $file->move($this->path, '', false);
        if($info){
            return true;
        }else{
            return false;
        }
    }

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

    protected function deleteFiles(){
        $filename = $this->path . request()->param('fileName');
        return unlink($filename);
    }

    //遍历文件
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
                                    'current'  => $current,
                                    'children' => $this->traverse($type, $f_path . '/')
                                ];
                            }else{
                                $url = str_replace(ROOT_PATH . 'public', '', $f_path);
                                $arr = [
                                    'title' => $file,
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

    protected function getFileInfo($filePath){
        $file  = fopen($filePath, "r");
        $info  = fstat($file);
        $units = array(' B', ' KB', ' MB', ' GB', ' TB');
        for ($i = 0; $info['size'] >= 1024 && $i < 4; $i++) $info['size'] /= 1024;
        return [
            'type'  => mime_content_type($filePath),
            'size'  =>  round($info['size'], 2).$units[$i],
            'ctime' => date('Y-m-d H:i:s', $info['ctime'])
        ];
        fclose($file);
    }

}