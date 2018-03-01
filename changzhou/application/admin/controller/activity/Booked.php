<?php
namespace app\admin\controller\activity;

use app\admin\controller\Common;
use app\model\database\ActivityBooked;
use app\model\database\ActivityActivity;
use app\model\database\WechatUser;

class Booked extends Common{
    public function select(){
        if(request()->has('openid') && !empty(request()->param()['openid'])){
            $openid = request()->param()['openid'];
            $map['openid'] = $openid;
        }
        if(request()->has('activity') && !empty(request()->param()['activity'])){
            $activity = request()->param()['activity'];
            $map['activity'] = $activity;
        }
        $page = request()->param('page');
        $limit = request()->param('limit');
        $start = $limit*($page - 1);
        $data = ActivityBooked::where(@$map)->limit($start, $limit)->order('createAt','desc')->select();
        $total = ActivityBooked::where(@$map)->count();
        if(isset($map['openid'])){
            foreach ($data as $key => $value) {
                $data[$key]['activity'] = ActivityActivity::field('title,time')->find($value->activity);
            }
        }
        if(isset($map['activity'])){
            foreach ($data as $key => $value) {
                $data[$key]['wechat'] = WechatUser::field('openid,nickname,headimgurl,sex,province')->where('openid', $value->openid)->find();
            }
        }
        return json([
            'code'  => true,
            'total' => $total,
            'data'  => $data
        ]);
    }
    public function find(){
        $_id = request()->param('_id');
        if(empty($_id)) return json([
            'code' => false,
            'msg'  => '参数错误！'
        ]);
        $data = ActivityBooked::find($_id);
        if($data){
            return json([
                'code' => true,
                'data' => $data
            ]);
        }
        return json([
            'code' => false,
            'msg'  => '没有找到结果！'
        ]);
    }
    public function insert(){
        $data = request()->param();
        if (!empty($data['_id'])) return json(['code'=>false, 'msg'=>'参数错误']);
        $ActivityBooked = new ActivityBooked;
        $data['createAt'] = time();
        $data['updateAt'] = time();
        $result = $ActivityBooked->insert($data);
        if ($result) {
            return json(['code'=>true, 'msg'=>'添加成功！']);
        }
        return json(['code'=>false, 'msg'=>'添加失败！']);
    }
    public function update(){
        $data = request()->param();
        if (empty($data['_id'])) return json(['code'=>false, 'msg'=>'参数错误']);
        $ActivityBooked = new ActivityBooked;
        //如果设置是否参与状态，则判断活动是否结束
        if(isset($data['visited'])){
            $booked = $ActivityBooked->find($data['_id']);
            $activity = ActivityActivity::field('time')->find($booked->activity);
            $etime = $activity->time['end'];
            $now = time() * 1000;
            if($now < $etime){
                return json([
                    'code' => false,
                    'msg'  => '活动还未结束！'
                ]);
            }
        }
        unset($data['createAt'],$data['updateAt']);
        $data['updateAt'] = time();
        $result = $ActivityBooked->update($data);
        if ($result) {
            return json(['code'=>true, 'msg'=>'修改成功！']);
        }
        return json(['code'=>false, 'msg'=>'修改失败！']);
    }
    public function delete(){
        if (empty(request()->param()['_id'])) return json([
                'code' => false,
                'msg'  => '非法参数！'
        ]);
        $_id = request()->param()['_id'];
        $bookInfo = ActivityBooked::find($_id);
        $result = ActivityBooked::destroy($_id);
        if ($result) {
            $total = ActivityBooked::where('activity', $bookInfo->activity)->count();
            $result = ActivityActivity::update([
                '_id' => $bookInfo->activity,
                'reservation.count' => $total
            ]);
            return json([
                'code' => true,
                'msg'  => '删除成功！'
            ]);
        }
        return json([
            'code' => false,
            'msg'  => '删除成功！'
        ]);
    }
    public function export(){
        $flag = false;
        if(request()->has('openid') && !empty(request()->param()['openid'])){
            $openid = request()->param()['openid'];
            $map['openid'] = $openid;
            $flag = true;
        }
        if(request()->has('activity') && !empty(request()->param()['activity'])){
            $activity = request()->param()['activity'];
            $map['activity'] = $activity;
            $flag = true;
        }
        if(!$flag) return json(['code'=>false,'msg'=>'参数错误！']);
        $data = ActivityBooked::where(@$map)->order('createAt','desc')->select();
        if(isset($map['openid'])){
            foreach ($data as $key => $value) {
                $data[$key]['activity'] = ActivityActivity::field('title,time')->find($value->activity);
            }
        }
        if(isset($map['activity'])){
            foreach ($data as $key => $value) {
                $data[$key]['wechat'] = WechatUser::field('openid,nickname,headimgurl,sex,province')->where('openid', $value->openid)->find();
            }
        }
        $Excel = new \PHPExcel();
        $Excel->setActiveSheetIndex(0);
        // 设置单元格默认高度
        $Excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(30);
        // // 设置第一行高度
        // $Excel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        // $Excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);

        if(!empty($map['activity'])){
            //合并单元格
            $Excel->getActiveSheet()->setCellValue('A1', '微信信息');
            $Excel->getActiveSheet()->mergeCells('A1:D1');
            $Excel->getActiveSheet()->setCellValue('A2', '昵称');
            $Excel->getActiveSheet()->setCellValue('B2', 'openid');
            $Excel->getActiveSheet()->setCellValue('C2', '性别');
            $Excel->getActiveSheet()->setCellValue('D2', '省份');
        }elseif(!empty($map['openid'])){
            // 合并单元格
            $Excel->getActiveSheet()->setCellValue('A1', '活动信息');
            $Excel->getActiveSheet()->mergeCells('A1:D1');
            $Excel->getActiveSheet()->setCellValue('A2', '名称');
            $Excel->getActiveSheet()->setCellValue('B2', 'id');
            $Excel->getActiveSheet()->setCellValue('C2', '开始时间');
            $Excel->getActiveSheet()->setCellValue('D2', '结束时间');
        }
        $Excel->getActiveSheet()->setCellValue('E1', '预约人信息');
        $Excel->getActiveSheet()->mergeCells('E1:L1');
        $Excel->getActiveSheet()->setCellValue('E2', '类型');
        $Excel->getActiveSheet()->setCellValue('F2', '姓名');
        $Excel->getActiveSheet()->setCellValue('G2', '年龄');
        $Excel->getActiveSheet()->setCellValue('H2', '性别');
        $Excel->getActiveSheet()->setCellValue('I2', '身份证');
        $Excel->getActiveSheet()->setCellValue('J2', '民族');
        $Excel->getActiveSheet()->setCellValue('K2', '联系电话');
        $Excel->getActiveSheet()->setCellValue('L2', '单位/学校');

        $Excel->getActiveSheet()->setCellValue('M1', '预约时间');
        $Excel->getActiveSheet()->mergeCells('M1:M2');

        $Excel->getActiveSheet()->setCellValue('N1', '参与状态');
        $Excel->getActiveSheet()->mergeCells('N1:N2');
        $i = 3;
        $sex = ['未知','男','女'];
        $type = ['未成年人','成年人'];
        foreach ($data as $key => $value) {
            $len = count($value['users']);
            $j = $i + $len - 1;
            if(isset($map['activity'])){
                $Excel->getActiveSheet()->setCellValueExplicit('A'.$i, $value['wechat']['nickname'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $Excel->getActiveSheet()->mergeCells('A'.$i.':A'.$j);
                $Excel->getActiveSheet()->setCellValueExplicit('B'.$i, $value['wechat']['openid'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $Excel->getActiveSheet()->mergeCells('B'.$i.':B'.$j);
                $Excel->getActiveSheet()->setCellValueExplicit('C'.$i, $sex[$value['wechat']['sex']], \PHPExcel_Cell_DataType::TYPE_STRING);
                $Excel->getActiveSheet()->mergeCells('C'.$i.':C'.$j);
                $Excel->getActiveSheet()->setCellValueExplicit('D'.$i, $value['wechat']['province'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $Excel->getActiveSheet()->mergeCells('D'.$i.':D'.$j);
            }
            if(isset($map['openid'])){
                $Excel->getActiveSheet()->setCellValueExplicit('A'.$i, $value['activity']['title'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $Excel->getActiveSheet()->mergeCells('A'.$i.':A'.$j);
                $Excel->getActiveSheet()->setCellValueExplicit('B'.$i, $value['activity']['_id'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $Excel->getActiveSheet()->mergeCells('B'.$i.':B'.$j);
                $Excel->getActiveSheet()->setCellValueExplicit('C'.$i, date('Y-m-d H:i:s', floor($value['activity']['time']['start']/1000)), \PHPExcel_Cell_DataType::TYPE_STRING);
                $Excel->getActiveSheet()->mergeCells('C'.$i.':C'.$j);
                $Excel->getActiveSheet()->setCellValueExplicit('D'.$i, date('Y-m-d H:i:s',floor($value['activity']['time']['end']/1000)), \PHPExcel_Cell_DataType::TYPE_STRING);
                $Excel->getActiveSheet()->mergeCells('D'.$i.':D'.$j);
            }
            $Excel->getActiveSheet()->setCellValueExplicit('M'.$i, $value['createAt'], \PHPExcel_Cell_DataType::TYPE_STRING);
            $Excel->getActiveSheet()->mergeCells('M'.$i.':M'.$j);

            $Excel->getActiveSheet()->setCellValueExplicit('N'.$i, isset($value['visited'])?($value['visited']?'已参与':'未参与'):'未知', \PHPExcel_Cell_DataType::TYPE_STRING);
            $Excel->getActiveSheet()->mergeCells('N'.$i.':N'.$j);
            // $Excel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setShrinkToFit(true);//字体变小以适应宽
            // $Excel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setWrapText(true);   //自动换行
            foreach ($value['users'] as $k => $v) {
                $Excel->getActiveSheet()->setCellValueExplicit('E'.$i, $type[$v['type']], \PHPExcel_Cell_DataType::TYPE_STRING);
                $Excel->getActiveSheet()->setCellValueExplicit('F'.$i, $v['name'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $Excel->getActiveSheet()->setCellValueExplicit('G'.$i, $v['age'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $Excel->getActiveSheet()->setCellValueExplicit('H'.$i, $v['sex']?'男':'女', \PHPExcel_Cell_DataType::TYPE_STRING);
                $Excel->getActiveSheet()->setCellValueExplicit('I'.$i, $v['idCard'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $Excel->getActiveSheet()->setCellValueExplicit('J'.$i, $v['nation'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $Excel->getActiveSheet()->setCellValueExplicit('K'.$i, $v['tel'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $Excel->getActiveSheet()->setCellValueExplicit('L'.$i, $v['type']?$v['work']:$v['school'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $i++;
            }
        }
        // 文件存放目录
        $dirPath = BASE_DIR.config('website.excelDir');
        if(!file_exists($dirPath)){
            mkdir($dirPath,0777,true);
        }
        // 删除1小时以前的文件
        $this->trash($dirPath, 3600 * 1);
        // 生成文件名
        $filename = 'a' . time() . '.xls';
        // 生成文件表格文件
        $Writer = new \PHPExcel_Writer_Excel5($Excel);
        $Writer->save($dirPath . '/' . $filename);
        return json([
            'code' => true,
            'filename' => $filename,
            'ext' => '.xls',
            'url' => config('website.prefix').config('website.excelDir').'/'.$filename
        ]);
    }
    // 删除某时间以前的文件
    protected function trash($folder, $time=10){
        $ext=array('php','htm','html'); //带有这些扩展名的文件不会被删除
        $o=opendir($folder);
        while($file=readdir($o)){
            if($file !='.' && $file !='..' && !in_array(substr($file,strrpos($file,'.')+1),$ext)){
                $fullPath=$folder.'/'.$file;
                if(is_dir($fullPath)){
                    $this->trash($fullPath, $time);
                    @rmdir($fullPath);
                } else {
                    if(time()-filemtime($fullPath) > $time){
                        unlink($fullPath);
                    }
                }
            }
        }
        closedir($o);
    }
}