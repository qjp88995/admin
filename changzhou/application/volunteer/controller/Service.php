<?php
namespace app\volunteer\controller;

use app\volunteer\controller\Common;
use app\model\database\VolunteerService;
use app\model\database\VolunteerBooked;
use app\model\database\VolunteerVolunteer;

class Service extends Common{
    public function select(){
        if(request()->has('category') && !empty(request()->param()['category'])){
            $cates = request()->param()['category'];
            $map['category.id'] = ['IN',$cates];
        }
        if(request()->has('title') && !empty(request()->param('title'))){
            $map['title'] = ['like', trim(request()->param('title'))];
        }
        if(request()->has('time') && !empty(request()->param()['time'])){
            $time = request()->param()['time'];
            $map['time.start'] = ['>', $time['start']];
            $map['time.end'] = ['<', $time['end']];
        }
        $map['isShow'] = true;
        $sort = request()->param('sort')=='ascend'?'asc':'desc';
        $page = request()->param('page');
        $limit = request()->param('limit');
        $start = $limit*($page-1);
        $data = VolunteerService::where($map)->field('content',true)->limit($start, $limit)->order('time.start','asc')->select();
        $total = VolunteerService::where($map)->count();
        return json([
            'code'  => true,
            'total' => $total,
            'data'  => $data
        ]);
    }
    public function find(){
        if(request()->has('_id')){
            $_id = request()->param('_id');
            $data = VolunteerService::find($_id);
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
    // 预约
    public function booking(){
        $_id = request()->param('_id');
        if(empty($_id)) return json(['code'=>false,'msg'=>'参数有误！']);
        $userId = session('_id','','volunteer');
        $userInfo = VolunteerVolunteer::find($userId);
        if(!$userInfo->status) return json(['code'=>false, 'msg'=>'账号已被拉黑!']);
        if(isset($userInfo->expiration) && $userInfo->expiration !=false && time() < $userInfo->expiration) return json(['code'=>false, 'msg'=>'账号违纪，被封一年!']);
        $service = VolunteerService::find($_id);
        if(!$service) return json(['code'=>false,'msg'=>'服务信息有误！']);
        $total = VolunteerBooked::where([
            'service' => $_id,
            'status'  => true
        ])->count();
        $limit = $service->reservation['limit'];
        $time = time() * 1000;
        if($time > $service->time['start']){
            return json([
                'code' => false,
                'msg'  => '已经开始'
            ]);
        }
        if($time > $service->time['end']){
            return json([
                'code' => false,
                'msg'  => '已经结束'
            ]);
        }
        if($total >= $limit){
            return json([
                'code' => false,
                'msg'  => '预约已满'
            ]);
        }
        $booked = VolunteerBooked::where([
            'volunteer' => $userId,
            'service'   => $_id
        ])->find();
        if($booked){
            if($booked->status==true){
                return json([
                    'code' => false,
                    'msg'  => '你已经预约过了！'
                ]);
            }else{
                $result = VolunteerBooked::update([
                    '_id' => $booked->_id,
                    'status' => true
                ]);
            }
        }else{
            $result = VolunteerBooked::insert([
                'service'   => $_id,
                'volunteer' => $userId,
                'status'    => true,
                'pass'      => 0,
                'createAt'  => time()
            ]);
        }
        if($result){
            $result = VolunteerService::update([
                '_id' => $_id,
                'reservation.count' => $total + 1
            ]);
            return json([
                'code' => true,
                'msg'  => '预约成功！'
            ]);
        }else{
            return json([
                'code' => false,
                'msg'  => '预约失败！'
            ]);
        }
    }
    // 取消预约
    public function cancelBooked(){
        $_id = request()->param('_id');
        if(empty($_id)) return json(['code'=>false,'msg'=>'参数有误！']);
        $userId = session('_id','','volunteer');

        $booked = VolunteerBooked::find($_id);
        if(!$booked) return json(['code'=>fakse,'msg'=>'预约信息有误！']);
        if($booked->status==false) return json(['code' => false,'msg'  => '你已经取消了']);

        $service = VolunteerService::find($booked->service);
        if(!$service) return json(['code'=>false,'msg'=>'服务信息有误！']);

        $time = time() * 1000;
        if($time > $service->time['start']){
            return json([
                'code' => false,
                'msg'  => '已经开始'
            ]);
        }
        if($time > $service->time['end']){
            return json([
                'code' => false,
                'msg'  => '已经结束'
            ]);
        }

        $result = VolunteerBooked::update([
            '_id' => $_id,
            'status' => false
        ]);
        if($result){
            $total = VolunteerBooked::where([
                'service' => $service->_id,
                'status'  => true
            ])->count();
            $result = VolunteerService::update([
                '_id' => $service->_id,
                'reservation.count' => $total
            ]);
            return json([
                'code' => true,
                'msg'  => '取消成功'
            ]);
        }else{
            return json([
                'code' => false,
                'msg'  => '取消失败'
            ]);
        }
    }
    // 签到签退
    public function sign(){
        $_id = request()->param('_id');
        if(empty($_id)) return json(['code'=>false,'msg'=>'参数有误！']);

        $userId = session('_id','','volunteer');

        $bookinfo = VolunteerBooked::find($_id);
        if(!$bookinfo) return json(['code'=>false,'msg'=>'预约信息有误']);

        $service = VolunteerService::find($bookinfo->service);
        if(!$service) return json(['code'=>false,'msg'=>'服务信息有误！']);

        $time = time() * 1000;
        $stime = $service->time['start'] - 10 * 60 * 1000;
        $etime = $service->time['end'] + 30 * 60 * 1000;

        if($time < $stime){
            return json([
                'code' => false,
                'msg'  => '签到时间还未到！'
            ]);
        }
        if($time > $etime){
            return json([
                'code' => false,
                'msg'  => '签退时间已过！'
            ]);
        }
        $data = [
            '_id' => $_id
        ];
        $sign = isset($bookinfo->sign)?$bookinfo->sign:[];
        if($time > $stime && $time < $service->time['start']){
            if(isset($sign['in'])){
                return json([
                    'code' => false,
                    'msg'  => '已经签过到了！'
                ]);
            }
            $sign['in'] = $time;
        }
        if($time > $service->time['end'] && $time < $etime){
            if(isset($sign['back'])){
                return json([
                    'code' => false,
                    'msg'  => '已经签过退了！'
                ]);
            }
            $sign['back'] = $time;
            $note = trim(request()->param('note'));
            if(empty($note)) return json(['code'=>false,'msg'=>'请填写备注！']);
            $data['note'] = $note;
        }
        $data['sign'] = $sign;
        $result = VolunteerBooked::update($data);
        if($result){
            return json([
                'code' => true,
                'msg'  => '操作成功！'
            ]);
        }
        return json([
            'code' => false,
            'msg'  => '操作失败！'
        ]);
    }
}