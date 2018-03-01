<?php
namespace app\visit\controller;

use think\Controller;

class Reservation extends Controller{
    const GET_DAYS_LINK = 'http://58.216.213.211:7002/tms/before/wei!getDaysOfInterview.json',
    GET_TICKET_TYPE_LINK = 'http://58.216.213.211:7002/tms/before/wei!getTicketTypeList.json',
    GET_PAGER_TYPE_LINK = 'http://58.216.213.211:7002/tms/before/wei!getPaperTypeList.json',
    SAVE_BOOKING_INFO = 'http://58.216.213.211:7002/tms/before/wei!saveBookingInfo.json',
    SAVE_GROUP_TICKET = 'http://58.216.213.211:7002/tms/before/wei!saveGroupTicket.json',
    SEARCH_MES_FOR_INTER = 'http://58.216.213.211:7002/tms/before/wei!searchMesForInter.json',
    SEARCH_DATA_FOR_BACK = 'http://58.216.213.211:7002/tms/before/wei!searchDataForBack.json',
    REFUND = 'http://58.216.213.211:7002/tms/before/wei!refund.json';
    // 可预约天数信息
    public function getDays(){
        $data = $this->httpGet(self::GET_DAYS_LINK);
        return $data;
    }
    // 门票类型
    public function getTicketType(){
        $data = $this->httpGet(self::GET_TICKET_TYPE_LINK);
        return $data;
    }
    // 证件类型
    public function getPaperType(){
        $data = $this->httpGet(self::GET_PAGER_TYPE_LINK);
        return $data;
    }
    // 保存个人预约信息
    public function saveBookingInfo(){
        $param = request()->param();
        $param['data'] = json_encode($param['data']);
        $data = $this->httpPost(self::SAVE_BOOKING_INFO, $param);
        return $data;
    }
    // 保存团队预约信息
    public function saveGroupTicket(){
        $param = request()->param();
        $param['data'] = json_encode($param['data']);
        $data = $this->httpPost(self::SAVE_GROUP_TICKET, $param);
        return $data;
    }
    // 个人预约信息查询
    public function searchMesForInter(){
        $param = request()->param();
        $data = $this->httpPOST(self::SEARCH_MES_FOR_INTER, $param);
        return $data;
    }
    // 查询退订信息
    public function searchDataForBack(){
        $param = request()->param();
        $data = $this->httpPOST(self::SEARCH_DATA_FOR_BACK, $param);
        return $data;
    }
    // 预约退票
    public function refund(){
        $param = request()->param();
        $data = $this->httpPost(self::REFUND, $param);
        return $data;
    }
    protected function httpGet($url){
        $ch = curl_init();
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => true
        ];
        curl_setopt_array($ch, $options);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    protected function httpPost($url, $param = []){
        $ch = curl_init();
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $param
        ];
        curl_setopt_array($ch, $options);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}