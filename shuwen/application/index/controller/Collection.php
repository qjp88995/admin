<?php
namespace app\index\controller;

use think\Controller;
use app\model\Collection as CollectionList;

class Collection extends Controller{
    public function index(){
        if(request()->isPost()){
            $page = request()->param('page');
            $limit = request()->param('limit');
            $start = $limit*($page-1);
            $list = CollectionList::where(@$map)->field('content,moreFields',true)->limit($start, $limit)->select();
            $count = CollectionList::where(@$map)->count();
            foreach ($list as $key => $value) {
                $list[$key] = [
                    'title'     => $value->title,
                    'href'      => '/collection/detail/'.$value->_id,
                    'src'       => $value->cover
                ];
            }
            return json([
                'count' => $count,
                'data'  => $list
            ]);
        }else{
            $sliders = CollectionList::where(['isSlider'=>true])->field('title,cover')->select();
            foreach ($sliders as $key => $value) {
                $sliders[$key] = [
                    'title' => $value->title,
                    'src'   => $value->cover,
                    'href'  => '/collection/detail/' . $value->_id
                ];
            }
            $this->assign([
                'sliders' => json_encode($sliders)
            ]);
            return $this->fetch();
        }
    }
    public function detail(){
        $id = request()->route('id');
        $detail = CollectionList::find($id);
        $this->assign('detail', $detail);
        return $this->fetch();
        return $this->fetch();
    }
}