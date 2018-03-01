<?php
namespace app\museum\controller;

use think\Controller;
use app\model\database\MuseumExhibit;
use app\model\database\MuseumExhibitLike;

class Exhibit extends Controller{
    public function select(){
        if(request()->has('exhibition') && !empty(request()->param()['exhibition'])){
            $exhibition = request()->param()['exhibition'];
            if(is_array($exhibition)){
                $map['exhibition.id'] = ['IN',$exhibition];
            }else{
                $map['exhibition.id'] = $exhibition;
            }
        }
        if(request()->has('search') && !empty(request()->param()['search'])){
            $search = request()->param()['search'];
            if(is_array($search)){
                $map['guideNum|uuid'] = ['IN', $search];
            }else{
                $map['title|guideNum|uuid'] = ['like', trim($search)];
            }
        }
        if(request()->has('title') && !empty(request()->param('title'))){
            $map['title'] = ['like', trim(request()->param('title'))];
        }
        if(request()->has('guideNum') && !empty(request()->param('guideNum'))){
            $map['guideNum'] = trim(request()->param('guideNum'));
        }
        if(request()->has('audios') && !empty(request()->param('audios'))){
            $map['$where'] = 'this.audios.length>0';
        }
        if(request()->has('createAt') && !empty(request()->param('createAt'))){
            $time = explode('/', request()->param('createAt'));
            foreach ($time as $k => $v) {
                $time[$k] = strtotime($v);
            }
            $map['createAt'] = ['between',$time];
        }
        $map['isShow'] = true;
        $page  = request()->param('page');
        $limit = request()->param('limit');
        $start = $limit*($page-1);
        $data  = MuseumExhibit::where($map)->limit($start, $limit)->order('sort','asc')->order('guideNum','asc')->select();
        $total = MuseumExhibit::where($map)->count();
        if($data){
            if(request()->has('openid') && !empty(request()->param('openid'))){
                $openid = request()->param('openid');
                foreach ($data as $key => $value) {
                    $like = MuseumExhibitLike::where([
                        'openid'=>$openid,
                        'exhibit'=>$value->_id
                    ])->find();
                    $data[$key]['isLike'] = $like?true:false;
                }
            }
            return json([
                'code'  => true,
                'total' => $total,
                'data'  => $data
            ]);
        }
        return json([
            'code'  => false,
            'msg'   => '查询失败！'
        ]);
    }
    public function find(){
        if(request()->has('_id')){
            $_id = request()->param('_id');
            $data = MuseumExhibit::find($_id);
        }else if(request()->has('guideNum')){
            $guideNum = request()->param('guideNum');
            $data = MuseumExhibit::where('guideNum',$guideNum)->find();
        }
        if($data){
            if(request()->has('openid') && !empty(request()->param('openid'))){
                $openid = request()->param('openid');
                $like = MuseumExhibitLike::where([
                    'openid'=>$openid,
                    'exhibit'=>$data->_id
                ])->find();
                $data[$key]['isLike'] = $like?true:false;
            }
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
    public function giveLike(){
        $openid = request()->param('openid');
        $exhibit = request()->param('exhibit');
        if(empty($openid) || empty($exhibit)){
            return json([
                'code' => false,
                'msg'  => '参数不正确！'
            ]);
        }
        $result = MuseumExhibitLike::where([
            'openid' => $openid,
            'exhibit' => $exhibit
        ])->find();
        if($result){
            $result = MuseumExhibitLike::destroy($result->_id);
            if($result){
                $count = MuseumExhibitLike::where('exhibit', $exhibit)->count();
                MuseumExhibit::update([
                    '_id'    => $exhibit,
                    'like' => $count
                ]);
                return json([
                    'code' => true,
                    'msg'  => '取消点赞成功！'
                ]);
            }else{
                return json([
                    'code' => false,
                    'msg'  => '取消点赞失败！'
                ]);
            }
        }else{
            $result = MuseumExhibitLike::insert([
                'openid' => $openid,
                'exhibit' => $exhibit
            ]);
            if($result){
                $count = MuseumExhibitLike::where('exhibit', $exhibit)->count();
                MuseumExhibit::update([
                    '_id'    => $exhibit,
                    'like' => $count
                ]);
                return json([
                    'code' => true,
                    'msg'  =>'点赞成功！'
                ]);
            }else{
                return json([
                    'code' => false,
                    'msg'  =>'点赞失败！'
                ]);
            }
        }
    }
    public function giveView(){
        $exhibit = request()->param('exhibit');
        if(empty($exhibit)){
            return json([
                'code' => false,
                'msg'  => '参数不正确！'
            ]);
        }
        $result = MuseumExhibit::find($exhibit);
        if($result){
            $view = empty($result['view'])?0:$result['view'];
            $result = MuseumExhibit::update([
                '_id'  => $exhibit,
                'view' => $view+1
            ]);
            if($result){
                return json([
                    'code' => true,
                    'msg'  => '浏览数+1'
                ]);
            }
        }
        return json([
            'code' => false,
            'msg'  => '请求失败！'
        ]);
    }
}