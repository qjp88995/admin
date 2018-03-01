<?php
namespace app\article\controller;

use app\common\controller\Auth;
use app\article\model\Module as Md;
use app\api\controller\Component;

class Module extends Auth{
    public function index(){
        $list = Md::paginate();
        $this->assign('page', $list);
        return $this->fetch();
    }

    public function add(){
        return $this->fetch();
    }

    public function insert(){
        if(empty(request()->param()['title'])) return $this->error('模板名称不能为空！');
        if(empty(request()->param()['moreFields'])) return $this->error('您没有填写模板字段！');
        $Md = new Md;
        $Md->title = request()->param()['title'];
        $Md->description = request()->param()['description'];
        $Md->moreFields = array_values(request()->param()['moreFields']);
        $result = $Md->save();
        if($result){
            return $this->success('添加成功！');
        }else{
            return $this->error('添加失败！');
        }
    }

    public function edit(){
        if(empty(request()->param('_id'))) $this->error('非法操作！');
        $_id = request()->param('_id');
        $Md = new Md;
        $result = $Md->where('_id',$_id)->find();
        $Component = new Component;
        $field = '';
        foreach ($result->moreFields as $v) {
            $field .= $Component->moreField($v);
        }
        $this->assign('module', $result);
        $this->assign('field', $field);
        return $this->fetch();
    }

    public function update(){
        if(empty(request()->param()['_id'])) return $this->error('非法操作！');
        if(empty(request()->param()['title'])) return $this->error('模板名称不能为空！');
        if(empty(request()->param()['moreFields'])) return $this->error('您没有填写模板字段！');
        $Md = new Md;
        $data['title'] = request()->param()['title'];
        $data['description'] = request()->param()['description'];
        $data['moreFields'] = array_values(request()->param()['moreFields']);
        $result = $Md->where('_id', request()->param('_id'))->update($data);
        if($result){
            return $this->success('更新成功！');
        }else{
            return $this->error('更新失败！');
        }
    }

    public function delete(){
        if(empty(request()->param('_id'))) return $this->error('非法操作！');
        $result = Md::destroy(request()->param('_id'));
        if (!empty($result)) {
            return $this->success('删除成功！');
        }else{
            return $this->error('删除失败！');
        }
    }
}