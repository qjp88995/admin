<?php
namespace app\admin\controller;

use app\common\controller\Auth;
use app\admin\model\Authority as Au;

class Authority extends Auth{
    protected $collection = 'bwg.admin_authority';
    public function index(){
        if(request()->isAjax()){
            $result = Au::select();
            return $result;
        }else{
            return $this->fetch();
        }
    }

    public function insert(){
        if(request()->has('title') && request()->has('allow') && request()->has('name')){
            $Au = new Au;
            $name = request()->param('name');
            $where = [
                $name => ['exists',true]
            ];
            $result = $Au->where($where)->find();
            if($result){
                return ['code'=> false, 'msg'=> '模块标识已被使用！'];
            }
            $data = [
                $name => [
                    '_title' => request()->param('title'),
                    '_allow' => intval(request()->param('allow'))
                ],
                'deleteAt' => 0
            ];
            $result = $Au->insert($data);
            if($result){
                return ['code'=> true, 'msg'=> '模块创建成功！'];
            }else{
                return ['code'=> false, 'msg'=> '模块创建失败！'];
            }
        }else{
            return ['code'=> false, 'msg'=> '模块信息不能为空！'];
        }
    }

    public function update(){
        //检测请求参数
        if(request()->has('title') && request()->has('allow') && request()->has('name') && request()->has('command') && request()->has('path') && request()->has('id')){
            $Au = new Au;
            //检测模块是否存在
            $result = $Au->find(request()->param('id'));
            if(!$result) return ['code'=> false, 'msg'=> '模块不存在！'];
            $name = request()->param('name');
            $path = request()->param('path');
            //如果是添加子类，则组合成新的path
            if(in_array(request()->param('command'), ['addController', 'addAction'])){
                $path .= '.' . $name;
                $where = [
                    $path => ['exists',true]
                ];
                $result = $Au->where($where)->find();
                if($result) return ['code'=> false, 'msg'=> "‘{$name}’标识已存在！"];
            }
            $newPath = $path;
            $pathArr = explode('.', $path);
            //如果更改了标识，则检测新的标识是否和已有的冲突，重新生成新的path
            if(!($name == end($pathArr))){
                array_pop($pathArr);
                array_push($pathArr, $name);
                $newPath = implode('.', $pathArr);
                $where = [
                    $newPath => ['exists',true]
                ];
                $result = $Au->where($where)->find();
                if($result) return ['code'=> false, 'msg'=> "‘{$name}’标识已存在！"];
            }
            //如果是修改
            if(in_array(request()->param('command'), ['editModule', 'editController', 'editAction'])){
                //如果标识变化，则修改标识
                $data = [
                    $newPath.'._title' => request()->param('title'),
                    $newPath.'._allow' => intval(request()->param('allow'))
                ];
                if(!($path == $newPath)){
                    $options = [
                        '$rename' => [
                            $path => $newPath
                        ]
                    ];
                    $bulk = new \MongoDB\Driver\BulkWrite();
                    $bulk->update([
                        "_id"=>new \MongoDB\BSON\ObjectID(request()->param('id'))
                    ], $options);
                    $writeConcern = new \MongoDB\Driver\WriteConcern(\MongoDB\Driver\WriteConcern::MAJORITY, 1000);
                    $Au->execute($this->collection, $bulk, $writeConcern);
                }
                //更新数据
                $result = $Au->where('_id', request()->param('id'))->update($data);
                return ['code'=> true, 'msg'=> "修改成功！"];
            }
            //如果是添加子类
            elseif(in_array(request()->param('command'), ['addController', 'addAction'])){
                $data = [
                    $newPath => [
                        '_title' => request()->param('title'),
                        '_allow' => intval(request()->param('allow'))
                    ]
                ];
                $result = $Au->where('_id', request()->param('id'))->update($data);
                if($result){
                    return ['code'=> true, 'msg'=> "添加成功！"];
                }else{
                    return ['code'=> false, 'msg'=> "添加失败！"];
                }
            }
            //否则返回错误
            else{
                return ['code'=> false, 'msg'=> '非法请求！'];
            }
        }
        //请求参数不正确，返回错误
        else{
            return ['code'=> false, 'msg'=> '请求参数有误！'];
        }
    }

    public function delete(){
        if(request()->has('id') && request()->has('command') && request()->has('path')){
            $au = new Au;
            //检测模块是否存在
            $result = $au->find(request()->param('id'));
            if(!$result) return ['code'=> false, 'msg'=> '模块不存在！'];
            $path = request()->param('path');
            $where = [
                $path => ['exists',true]
            ];
            $result = $au->where($where)->find();
            if(!$result) return ['code'=> true, 'msg'=> "删除成功！"];
            if(request()->param('command') == 'rmModule'){
                $result = Au::destroy(request()->param('id'));
                if($result){
                    return ['code'=> true, 'msg'=> '删除成功！'];
                }else{
                    return ['code'=> false, 'msg'=> '删除失败！'];
                }
            }elseif(in_array(request()->param('command'), ['rmController', 'rmAction'])){
                $options = [
                    '$unset' => [
                        $path => 1
                    ]
                ];
                $bulk = new \MongoDB\Driver\BulkWrite();
                $bulk->update([
                    "_id"=>new \MongoDB\BSON\ObjectID(request()->param('id'))
                ], $options);
                $writeConcern = new \MongoDB\Driver\WriteConcern(\MongoDB\Driver\WriteConcern::MAJORITY, 1000);
                $au->execute($this->collection, $bulk, $writeConcern);
                return ['code'=> true, 'msg'=> '删除成功！'];
            }else{
                return ['code'=> false, 'msg'=> '非法操作！'];
            }
        }else{
            return ['code'=> false, 'msg'=> '请求参数有误！'];
        }
    }
}