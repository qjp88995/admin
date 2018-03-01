<?php
namespace app\admin\controller\volunteer;

use app\admin\controller\Common;
use app\model\database\VolunteerBooked;
use app\model\database\VolunteerService;
use app\model\database\VolunteerVolunteer;

class Booked extends Common{
    public function select(){
        if(request()->has('level') && !empty(request()->param()['level'])){
            $level = request()->param()['level'];
            $map['level'] = $level;
        }
        if(request()->has('volunteer') && !empty(request()->param()['volunteer'])){
            $volunteer = request()->param()['volunteer'];
            $map['volunteer'] = $volunteer;
        }
        if(request()->has('service') && !empty(request()->param()['service'])){
            $service = request()->param()['service'];
            $map['service'] = $service;
        }
        // 不显示已经取消的
        $map['status'] = true;
        $page = request()->param('page');
        $limit = request()->param('limit');
        $start = $limit*($page - 1);
        $data = VolunteerBooked::where(@$map)->limit($start, $limit)->order('createAt','desc')->select();
        $total = VolunteerBooked::where(@$map)->count();
        if(isset($map['volunteer'])){
            foreach ($data as $key => $value) {
                $data[$key]['service'] = VolunteerService::field('title,time')->find($value->service);
            }
        }
        if(isset($map['service'])){
            foreach ($data as $key => $value) {
                $data[$key]['volunteer'] = VolunteerVolunteer::field('name,tel,idCard')->find($value->volunteer);
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
        $data = VolunteerBooked::find($_id);
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
        $VolunteerBooked = new VolunteerBooked;
        $data['createAt'] = time();
        $data['updateAt'] = time();
        $result = $VolunteerBooked->insert($data);
        if ($result) {
            return json(['code'=>true, 'msg'=>'添加成功！']);
        }else{
            return json(['code'=>false, 'msg'=>'添加失败！']);
        }
    }
    public function update(){
        $data = request()->param();
        if (empty($data['_id'])) return json(['code'=>false, 'msg'=>'参数错误']);
        $VolunteerBooked = new VolunteerBooked;
        // 如果是审核通过的操作
        if(isset($data['pass'])){
            $data['pass'] = intval($data['pass']);
            $bookInfo = $VolunteerBooked->find($data['_id']);
            if(!$bookInfo) return json(['code'=>false, 'msg'=>'预约信息不存在！']);
            // 如果没有签到签退、签到、签退信息
            if($data['pass'] === 1){
                if(!isset($bookInfo->sign) || !$bookInfo->sign['in'] || !$bookInfo->sign['back']){
                    $service = VolunteerService::find($bookInfo->service);
                    if(!$service) return json(['code'=>false, 'msg'=>'服务信息有误！']);

                    if(!isset($bookInfo->sign)){// 如果没有签到签退信息
                        $data['sign'] = [
                            'in' => $service->time['start'],
                            'back' => $service->time['end']
                        ];
                    }else if(!$bookInfo->sign['in']){//如果没有签到信息
                        $data['sign']['in'] = $service->time['start'];
                    }else if(!$bookInfo->sign['back']){//如果没有签退信息
                        $data['sign']['back'] = $service->time['end'];
                    }
                }
            }
        }
        unset($data['createAt'],$data['updateAt']);
        $data['updateAt'] = time();
        $result = $VolunteerBooked->update($data);
        if ($result) {
            if(isset($data['pass'])){
                $res = $this->setStatisticsDefault($bookInfo->volunteer);
            }
            return json(['code'=>true, 'msg'=>'修改成功！']);
        }else{
            return json(['code'=>false, 'msg'=>'修改失败！']);
        }
    }
    public function delete(){
        if (empty(request()->param()['_id'])) return json([
                'code' => false,
                'msg'  => '非法参数！'
            ]);
        $_id = request()->param()['_id'];
        $bookInfo = VolunteerBooked::find($_id);
        $result = VolunteerBooked::destroy($_id);
        if ($result) {
            $total = VolunteerBooked::where('service', $bookInfo->service)->count();
            $result = VolunteerService::update([
                '_id' => $bookInfo->service,
                'reservation.count' => $total
            ]);
            return json([
                'code' => true,
                'msg'  => '删除成功！'
            ]);
        }else{
            return json([
                'code' => false,
                'msg'  => '删除成功！'
            ]);
        }
    }
    protected function setStatisticsDefault($vid){
        $VolunteerBooked = new VolunteerBooked;
        $map = [
            'status' => true,
            'pass'   => 1
        ];
        $bout = $VolunteerBooked->where($map)->count();
        $ins = $VolunteerBooked->where($map)->sum('sign.in');
        $backs = $VolunteerBooked->where($map)->sum('sign.back');
        $data['statistics'] = [
            'bout' => 5,
            'times' => $backs - $ins
        ];
        $data['_id'] = $vid;
        $map['pass'] = -1;
        $year = date('Y');
        $map['createAt'] = ['between',[
            strtotime($year . '-01-01 00:00:00'),
            strtotime(($year + 1) . '-01-01 00:00:00'),
        ]];

        $volunteer = VolunteerVolunteer::find($vid);
        $expiration = isset($volunteer->expiration)?$volunteer->expiration:false;
        if(!$expiration || date('Y', $expiration) != $year){
            $default = $VolunteerBooked->where($map)->count();
            if($default>=3){
                $data['expiration'] = strtotime('+ 1 year');
            }else{
                $data['expiration'] = false;
            }
        }
        $result = VolunteerVolunteer::update($data);
        return $result;
    }
    public function export(){
        $flag = false;
        if(request()->has('volunteer') && !empty(request()->param()['volunteer'])){
            $volunteer = request()->param()['volunteer'];
            $map['volunteer'] = $volunteer;
            $flag = true;
        }
        if(request()->has('service') && !empty(request()->param()['service'])){
            $service = request()->param()['service'];
            $map['service'] = $service;
            $flag = true;
        }
        $map['status'] = true;
        if(!$flag) return json(['code'=>false,'msg'=>'参数错误！']);
        $data = VolunteerBooked::where(@$map)->order('createAt','desc')->select();
        if(isset($map['volunteer'])){
            foreach ($data as $key => $value) {
                $data[$key]['service'] = VolunteerService::field('title,time')->find($value->service);
            }
        }
        if(isset($map['service'])){
            foreach ($data as $key => $value) {
                $data[$key]['volunteer'] = VolunteerVolunteer::field('name,tel,idCard')->find($value->volunteer);
            }
        }
        $Excel = new \PHPExcel();
        $Excel->setActiveSheetIndex(0);
        // 设置单元格默认高度
        $Excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(30);
        // // 设置第一行高度
        // $Excel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        // $Excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);

        if(!empty($map['service'])){
            //合并单元格
            $Excel->getActiveSheet()->setCellValue('A1', '志愿者信息');
            $Excel->getActiveSheet()->mergeCells('A1:D1');
            $Excel->getActiveSheet()->setCellValue('A2', 'id');
            $Excel->getActiveSheet()->setCellValue('B2', '姓名');
            $Excel->getActiveSheet()->setCellValue('C2', '身份证号');
            $Excel->getActiveSheet()->setCellValue('D2', '联系电话');
        }elseif(!empty($map['volunteer'])){
            // 合并单元格
            $Excel->getActiveSheet()->setCellValue('A1', '服务信息');
            $Excel->getActiveSheet()->mergeCells('A1:D1');
            $Excel->getActiveSheet()->setCellValue('A2', 'id');
            $Excel->getActiveSheet()->setCellValue('B2', '名称');
            $Excel->getActiveSheet()->setCellValue('C2', '开始时间');
            $Excel->getActiveSheet()->setCellValue('D2', '结束时间');
        }
        $Excel->getActiveSheet()->setCellValue('E1', '签到时间');
        $Excel->getActiveSheet()->mergeCells('E1:E2');
        $Excel->getActiveSheet()->setCellValue('F1', '签退时间');
        $Excel->getActiveSheet()->mergeCells('F1:F2');

        $Excel->getActiveSheet()->setCellValue('G1', '预约时间');
        $Excel->getActiveSheet()->mergeCells('G1:G2');

        $Excel->getActiveSheet()->setCellValue('H1', '审核状态');
        $Excel->getActiveSheet()->mergeCells('H1:H2');
        $i = 3;
        foreach ($data as $key => $value) {
            if(isset($map['service'])){
                $Excel->getActiveSheet()->setCellValueExplicit('A'.$i, $value['volunteer']['_id'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $Excel->getActiveSheet()->setCellValueExplicit('B'.$i, $value['volunteer']['name'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $Excel->getActiveSheet()->setCellValueExplicit('C'.$i, $value['volunteer']['idCard'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $Excel->getActiveSheet()->setCellValueExplicit('D'.$i, $value['volunteer']['tel'], \PHPExcel_Cell_DataType::TYPE_STRING);
            }
            if(isset($map['volunteer'])){
                $Excel->getActiveSheet()->setCellValueExplicit('A'.$i, $value['service']['_id'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $Excel->getActiveSheet()->setCellValueExplicit('B'.$i, $value['service']['title'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $Excel->getActiveSheet()->setCellValueExplicit('C'.$i, date('Y-m-d H:i:s', floor($value['service']['time']['start']/1000)), \PHPExcel_Cell_DataType::TYPE_STRING);
                $Excel->getActiveSheet()->setCellValueExplicit('D'.$i, date('Y-m-d H:i:s',floor($value['service']['time']['end']/1000)), \PHPExcel_Cell_DataType::TYPE_STRING);
            }

            $Excel->getActiveSheet()->setCellValueExplicit('E'.$i, !empty($value['sign'])&&!empty($value['sign']['in'])?date('Y-m-d H:i:s', floor($value['sign']['in']/1000)):'未签到', \PHPExcel_Cell_DataType::TYPE_STRING);
            $Excel->getActiveSheet()->setCellValueExplicit('F'.$i, !empty($value['sign'])&&!empty($value['sign']['back'])?date('Y-m-d H:i:s', floor($value['sign']['back']/1000)):'未签退', \PHPExcel_Cell_DataType::TYPE_STRING);

            $Excel->getActiveSheet()->setCellValueExplicit('G'.$i, $value['createAt'], \PHPExcel_Cell_DataType::TYPE_STRING);

            $Excel->getActiveSheet()->setCellValueExplicit('H'.$i, isset($value['pass'])||!empty($value['pass'])?($value['pass']==1?'通过':'未通过'):'未审核', \PHPExcel_Cell_DataType::TYPE_STRING);
            // $Excel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setShrinkToFit(true);//字体变小以适应宽
            // $Excel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setWrapText(true);   //自动换行
            $i++;
        }
        // 文件存放目录
        $dirPath = BASE_DIR.config('website.excelDir');
        if(!file_exists($dirPath)){
            mkdir($dirPath,0777,true);
        }
        // 删除1小时以前的文件
        $this->trash($dirPath, 3600 * 1);
        // 生成文件名
        $filename = 'v' . time().'.xls';
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