<?php
namespace app\api\model;

/**
 * 腾讯地图api
 */
class Txmap {

    //腾讯地图key
    protected $key = 'JNRBZ-6M4KQ-KTY53-GCVWT-2ESQT-SYFNN';

    protected $url = 'http://apis.map.qq.com/ws/district/v1/';

    /**
     * 获取全部行政区
     */
    public function getList(){
        $url = $this->url . 'list' . '?key=' . $this->key;
        return file_get_contents($url);
    }

    /**
     * 获取XXX的子级行政区划
     * @param number $id 地区id
     * @return json字符串
     */
    public function getchildren($id){
        $whereId = !empty($id)?'&id=' . $id:'';
        $url = $this->url . 'getchildren' . '?key=' . $this->key . $whereId;
        return file_get_contents($url);
    }

    /**
     * 搜索关键词为XXX的行政区划
     */
    public function search($keyword){

    }

    protected function Curl(){

    }
}