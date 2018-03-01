<?php
namespace app\classroom\controller;

use app\common\controller\Auth;
use app\classroom\model\Question as Q;
// use app\api\controller\Component;
use app\classroom\model\Cate as Ct;
// use app\article\model\Module as Md;

class Question extends Auth{
    public function index(){
        if(request()->isAjax()){
            if(!trim(empty(request()->param('title')))){
                $where['title'] = ['like', trim(request()->param('title'))];
            }
            if(!trim(empty(request()->param('_id')))){
                return Q::find(request()->param('_id'));
            }
            $list = Q::where(@$where)->paginate();
            return $list;
        }else{
            $cates = $this->getCates(0);
            $this->assign('cates', json_encode($cates));
            return $this->fetch();
        }
    }

    // public function add(){
    //     if (empty(request()->param('cid'))) return $this->error('非法操作！');
    //     $fields = '';
    //     $Ct = Ct::find(request()->param('cid'));
    //     if(!empty($Ct)){
    //         if(!empty($Ct->contentFieldsTmpl)){
    //             $md = Md::find($Ct->contentFieldsTmpl);
    //             if(!empty($md)){
    //                 $Component = new Component;
    //                 foreach ($md->moreFields as $v) {
    //                     $fields .= $Component->moreField($v);
    //                 }
    //             }
    //         }
    //         $this->assign('Ct', $Ct);
    //         $this->assign('fields', $fields);
    //         return $this->fetch();
    //     }else{
    //         return $this->error('所选分类不存在！');
    //     }
    // }

    public function insert(){
        $data = [
            'category'    => [
                'id'    => request()->param('category'),
                'title' => ''
            ],
            'title'       => request()->param('title'),
            'cover'       => request()->param('cover'),
            'intro'       => request()->param('intro'),
            'type'        => request()->param('type'),
            'explain'     => request()->param('explain'),
            'createAt'    => time(),
            'updateAt'    => time(),
            'deleteAt'    => 0,
        ];
        $data['category']['title'] = Ct::field('title')->find($data['category']['id'])->title;
        if(request()->has('options')){
            $data['options'] = array_values(request()->param()['options']);
        }
        if(request()->has('answer')){
            $data['answer'] = request()->param()['answer'];
        }
        $Q = new Q;
        $result = $Q->insert($data);
        if(request()->isAjax()){
            if($result){
                return true;
            }else{
                return false;
            }
        }else{
            if($result){
                return $this->success('添加成功!');
            }else{
                return $this->error('添加失败！');
            }
        }
    }

    // public function edit(){
    //     if (empty(request()->param('_id'))) return $this->error('非法操作！');
    //     $_id = request()->param('_id');
    //     $result = Q::find($_id);
    //     if(!$result){
    //         $this->error('操作失败！');
    //     }
    //     $Component = new Component;
    //     $fields = '';
    //     foreach ($result->moreFields as $v) {
    //         $fields .= $Component->moreField($v);
    //     }
    //     $this->assign('info', $result);
    //     $this->assign('fields', $fields);
    //     $cates = Ct::where('ref', 'exhibit')->select();
    //     $this->assign('category', $cates);
    //     return $this->fetch();
    // }

    public function update(){
        if (empty(request()->param('_id'))) return $this->error('非法操作！');
        $data = [];
        if(request()->has('category') && gettype(request()->param()['category']) == 'string'){
            $data['category']['id'] = request()->param()['category'];
            $data['category']['title'] = Ct::field('title')->find($data['category']['id'])->title;
        }
        if(request()->has('title')){
            $data['title'] = request()->param()['title'];
        }
        if(request()->has('cover')){
            $data['cover'] = request()->param()['cover'];
        }
        if(request()->has('intro')){
            $data['intro'] = request()->param()['intro'];
        }
        if(request()->has('explain')){
            $data['explain'] = request()->param()['explain'];
        }
        if(request()->has('options')){
            $data['options'] = array_values(request()->param()['options']);
        }
        if(request()->has('answer')){
            $data['answer'] = request()->param()['answer'];
        }
        $data['updateAt'] = time();
        $Q = new Q;
        $result = $Q->where('_id', request()->param('_id'))->update($data);
        if(request()->isAjax()){
            if($result){
                return true;
            }else{
                return false;
            }
        }else{
            if($result){
                return $this->success('更新成功!');
            }else{
                return $this->error('更新失败！');
            }
        }
    }

    public function delete(){
        if(request()->isAjax()){
            if (empty(request()->param('_id'))) return 3;
            $_id = request()->param('_id');
            $result = Q::destroy($_id);
            if ($result) {
                return true;
            }else{
                return 1;
            }
        }else{
            return 2;
        }
    }

    protected function getCates($pid){
        $cates = Ct::field('title')->where('ref', 'question')->where('parent.id', $pid)->select();
        if(!empty($cates)){
            foreach ($cates as $k => $v) {
                $cates[$k]->children = $this->getCates((string)$v->_id);
            }
        }
        return $cates;
    }
}