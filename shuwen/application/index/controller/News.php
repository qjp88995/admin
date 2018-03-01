<?php
namespace app\index\controller;

use think\Controller;
use app\model\News as NewsList;

class News extends Controller{
    public function index(){
        if(request()->isPost()){
            if(!empty(request()->param('category'))){
                $map['category.name'] = request()->param('category');
            }
            if(!empty(request()->param('title'))){
                $map['title'] = ['like', request()->param('title')];
            }
            $page = request()->param('page');
            $limit = request()->param('limit');
            $start = $limit*($page-1);
            $list = NewsList::where(@$map)->field('content,moreFields',true)->limit($start, $limit)->select();
            $count = NewsList::where(@$map)->count();
            foreach ($list as $key => $value) {
                $list[$key] = [
                    'title'=> $value->title,
                    'time' => $value->getData('createAt'),
                    'href' => '/news/detail/'.$value->_id
                ];
            }
            return json([
                'count' => $count,
                'data'  => $list
            ]);
        }else{
            return $this->fetch();
        }
    }
    public function detail(){
        $id = request()->route('id');
        $detail = NewsList::find($id);
        $this->assign('detail', $detail);
        return $this->fetch();
    }
}