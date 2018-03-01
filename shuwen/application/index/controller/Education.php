<?php
namespace app\index\controller;

use think\Controller;
use app\model\Education as EducationList;

class Education extends Controller{
    public function index(){
        if(request()->isPost()){
            if(request()->param('time')){
                $timeList = EducationList::field('startTime,endTime')->select();
                return json($timeList);
            }
            $page = request()->param('page');
            $limit = request()->param('limit');
            $start = $limit*($page-1);
            $list = EducationList::where(@$map)->field('content,moreFields',true)->limit($start, $limit)->select();
            $count = EducationList::where(@$map)->count();
            foreach ($list as $key => $value) {
                $list[$key] = [
                    'title'     => $value->title,
                    'href'      => '/education/detail/'.$value->_id,
                    'src'       => $value->cover,
                    'startTime' => $value->startTime,
                    'endTime'   => $value->endTime,
                    'addr'      => $value->address,
                    'speaker'   => $value->speaker
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
        $detail = EducationList::find($id);
        $this->assign('detail', $detail);
        return $this->fetch();
    }
}