<?php
namespace app\index\controller;

use think\Controller;
use app\model\Exhibition as ExhibitionList;

class Exhibition extends Controller{
    public function index(){
        if(request()->isPost()){
            $list = ExhibitionList::select();
            foreach ($list as $key => $value) {
                $list[$key] = [
                    'title'     => $value->title,
                    'href'      => '/exhibition/detail/'.$value->_id,
                    'src'       => $value->cover,
                    'startTime' => $value->startTime,
                    'endTime'   => $value->endTime
                ];
            }
            return json($list);
        }else{
            $sliders = ExhibitionList::where(['isSlider'=>true])->field('title,cover')->select();
            foreach ($sliders as $key => $value) {
                $sliders[$key] = [
                    'title' => $value->title,
                    'src'   => $value->cover,
                    'href'  => '/exhibition/detail/' . $value->_id
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
        $detail = ExhibitionList::find($id);
        $this->assign('detail', $detail);
        return $this->fetch();
    }
}