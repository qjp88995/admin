<?php
namespace app\museum\controller;

use think\Controller;
use app\model\database\MuseumExhibition;

class Exhibition extends Controller{
    public function select(){
        if(request()->has('category') && !empty(request()->param()['category'])){
            $cates = request()->param()['category'];
            $map['category.id'] = ['IN',$cates];
        }
        if(request()->has('title') && !empty(request()->param('title'))){
            $map['title'] = ['like', trim(request()->param('title'))];
        }
        if(request()->has('type') && !empty(request()->param('type'))){
            $map['type'] = trim(request()->param('type'));
            if(request()->has('time') && request()->param('type') == 't'){
                $nowTime = time()*1000;
                switch (request()->param('time')) {
                    case 'current':
                        $map['time.start'] = ['<', $nowTime];
                        $map['time.end'] = ['>', $nowTime];
                        break;
                    case 'past':
                        $map['time.end'] = ['<', $nowTime];
                        break;
                    case 'future':
                        $map['time.start'] = ['>', $nowTime];
                        break;
                    case 'noEnd':
                        $map['time.end'] = ['>', $nowTime];
                        break;
                }
            }
        }
        if(request()->has('createAt') && !empty(request()->param('createAt'))){
            $time = explode('/', request()->param('createAt'));
            foreach ($time as $k => $v) {
                $time[$k] = strtotime($v);
            }
            $map['createAt'] = ['between',$time];
        }
        $map['isShow'] = true;
        $sort = request()->param('sort')=='ascend'?'asc':'desc';
        $page = request()->param('page');
        $limit = request()->param('limit');
        $start = $limit*($page-1);
        $data = MuseumExhibition::where($map)->field('content',true)->limit($start, $limit)->order('sort',$sort)->select();
        $total = MuseumExhibition::where($map)->count();
        return json([
            'code'  => true,
            'total' => $total,
            'data'  => $data
        ]);
    }
    public function find(){
        if(request()->has('_id')){
            $_id = request()->param('_id');
            $data = MuseumExhibition::find($_id);
        }else{
            return json([
                'code' => false,
                'msg'  => '参数错误！'
            ]);
        }
        if($data){
            return json([
                'code' => true,
                'result' => $data
            ]);
        }
        return json([
            'code' => false,
            'msg'  => '查询失败！'
        ]);
    }
}