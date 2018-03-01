<?php
namespace app\activity\controller;

use app\activity\controller\Common;
use app\model\database\ActivityCategory;
use app\model\database\ActivityActivity;
use app\model\database\ActivityBooked;
use app\model\database\WechatUser;

class Activity extends Common{
    public function select(){
        if(request()->has('category')){
            $name = request()->param('category');
            if(!in_array($name, ['education', 'lecture'])){
                return json([
                    'code' => false,
                    'msg'  => '分类参数有误！'
                ]);
            }
            $category = ActivityCategory::where([
                'isShow' => true,
                'name'   => $name
            ])->find();
            if(!$category){
                return json([
                    'code' => false,
                    'msg'  => '没有查到结果'
                ]);
            }
            $map['category.id'] = $category->_id;
        }
        if(request()->has('title') && !empty(request()->param('title'))){
            $map['title'] = ['like', trim(request()->param('title'))];
        }
        if(request()->has('type') && !empty(request()->param('type'))){
            $map['type'] = trim(request()->param('type'));
        }
        if(request()->has('time')){
            $time = request()->param()['time'];
            if(is_array($time)){
                if(!array_key_exists('start', $time) || !array_key_exists('end', $time)){
                    return json([
                        'code' => false,
                        'msg'  => '时间参数不正确'
                    ]);
                }
                $map['time.start'] = ['>', $time['start']];
                $map['time.end']   = ['>', $time['end']];
            }else{
                if(!in_array($time, ['current', 'past', 'future', 'noEnd'])){
                    return json([
                        'code' => false,
                        'msg'  => '时间参数不正确'
                    ]);
                }
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
        $map['isShow'] = true;
        $page = request()->param('page');
        $limit = request()->param('limit');
        $start = $limit*($page-1);
        $data = ActivityActivity::where($map)->field('content',true)->limit($start, $limit)->order('time.start','asc')->select();
        $total = ActivityActivity::where($map)->count();
        return json([
            'code'  => true,
            'total' => $total,
            'data'  => $data
        ]);
    }
    public function find(){
        $_id = request()->param('_id');
        if(empty($_id)) return json(['code'=>false, 'msg'=>'参数不正确！']);
        $data = ActivityActivity::find($_id);
        if($data){
            return json([
                'code' => true,
                'data' => $data
            ]);
        }
        return json([
            'code' => false,
            'data' => '查询无结果！'
        ]);
    }
    public function booking(){
        $_id = request()->param('_id');
        $users = request()->param()['users'];

        if(empty($_id) || !is_array($users) || empty($users)) return json(['code'=>false,'msg'=>'参数有误！']);

        //活动信息判断
        $activity = ActivityActivity::find($_id);
        if(!$activity) return json(['code'=>false,'msg'=>'活动信息有误！']);

        //账户判断
        $userId = session('_id','','wechat');
        $userInfo = WechatUser::find($userId);
        if(!$userInfo->status) return json(['code'=>false,'msg'=>'账号已被拉黑!']);

        //时间判断
        $time = time() * 1000;
        if($time > $activity->time['start']){
            return json([
                'code' => false,
                'msg'  => '已经开始'
            ]);
        }
        if($time > $activity->time['end']){
            return json([
                'code' => false,
                'msg'  => '已经结束'
            ]);
        }

        //人数判断
        $total = ActivityBooked::where('activity', $_id)->count();
        $limit = $activity->reservation['limit'];
        if($total >= $limit){
            return json([
                'code' => false,
                'msg'  => '预约已满'
            ]);
        }

        //类型判断
        $category = $activity['category']['name'];
        $len = count($users);
        $type = isset($activity['type'])?$activity['type']:'';
        //如果是教育活动
        if($category=='education'){
            //成人活动
            if($type=='adult'){
                if($len > 1) return json(['code'=>false,'msg'=>'成人活动只能报名1人！']);
                if($users[0]['type'] != 1){
                    return json([
                        'code' => false,
                        'msg'  => '请报名一个成人！'
                    ]);
                }
            }
            //未成年人活动
            if($type=='minor'){
                if($len > 1) return json(['code'=>false,'msg'=>'未成年人活动只能报名1人！']);
                if($users[0]['type'] != 0){
                    return json([
                        'code' => false,
                        'msg'  => '请报名一个未成年人！'
                    ]);
                }
            }
            //亲子活动
            if($type=='parent-child'){
                if($len !== 2) return json(['code'=>false,'msg'=>'亲子活动需要报名2人！']);
                if($users[0]['type'] === $users[1]['type']){
                    return json([
                        'code' => false,
                        'msg'  => '请报名一个成人和一个未成年人！'
                    ]);
                }
            }
        }
        //如果是讲座
        if($category=='lecture'){
            if($len > 2){
                return json([
                    'code' => false,
                    'msg'  => '人数不能超过2个！'
                ]);
            }
            foreach ($users as $value) {
                if($value['type']==0){
                    return json([
                        'code' => false,
                        'msg'  => '请报名两个成人！'
                    ]);
                }
            }
        }
        //年龄年级判断
        $t_limit = $activity->limit;
        if($t_limit['type']=='age'){
            $age = $t_limit['age'];
            foreach ($users as $key => $value) {
                if($value['age']<$age['min'] || $value['age']>$age['max']){
                    return json([
                        'code' => false,
                        'msg'  => '年龄不符合'
                    ]);
                }
            }
        }
        if($t_limit['type']=='grade'){
            $grade = $t_limit['grade'];
            foreach ($users as $key => $value) {
                if($value['type']==0 && ($value['grade']<$grade['min'] || $value['grade']>$grade['max'])){
                    return json([
                        'code' => false,
                        'msg'  => '年级不符合'
                    ]);
                }
            }
        }

        $booked = ActivityBooked::where([
            'openid'   => $userInfo->openid,
            'activity' => $_id
        ])->find();
        if($booked){
            return json([
                'code' => false,
                'msg'  => '你已经预约过了！'
            ]);
        }
        $result = ActivityBooked::insert([
            'activity' => $_id,
            'openid'   => $userInfo->openid,
            'users'    => $users,
            'createAt' => time()
        ]);
        if($result){
            $result = ActivityActivity::update([
                '_id' => $_id,
                'reservation.count' => $total + 1
            ]);
            return json([
                'code' => true,
                'msg'  => '预约成功！'
            ]);
        }
        return json([
            'code' => false,
            'msg'  => '预约失败！'
        ]);
    }
    // 取消预约
    public function cancelBooked(){
        $_id = request()->param('_id');
        if(empty($_id)) return json(['code'=>false,'msg'=>'参数有误！']);
        $userId = session('_id','','wechat');
        $openid = session('openid', '', 'wechat');

        $booked = ActivityBooked::find($_id);
        if(!$booked) return json(['code'=>fakse,'msg'=>'预约信息有误！']);

        $activity = ActivityActivity::find($booked->activity);
        if(!$activity) return json(['code'=>false,'msg'=>'活动信息有误！']);

        $time = time() * 1000;
        if($time > $activity->time['start'] - (3 * 24 * 60 * 60 * 1000)){
            return json([
                'code' => false,
                'msg'  => '已经超过取消时间'
            ]);
        }
        if($time > $activity->time['end']){
            return json([
                'code' => false,
                'msg'  => '已经结束'
            ]);
        }

        $result = ActivityBooked::destroy($_id);
        if($result){
            $total = ActivityBooked::where('activity', $activity->_id)->count();
            $result = ActivityActivity::update([
                '_id' => $activity->_id,
                'reservation.count' => $total
            ]);
            return json([
                'code' => true,
                'msg'  => '取消成功'
            ]);
        }
        return json([
            'code' => false,
            'msg'  => '取消失败'
        ]);
    }
}