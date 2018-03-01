<?php
namespace app\article\controller;

use app\common\controller\Auth;
use app\article\model\Article as Atc;
use app\article\model\Cate as Ct;

class Recycle extends Auth{
    public function index(){
        if(request()->isAjax()){
            if(request()->param('type') == 'cate'){
                $list = Ct::where('is_delete', '<>', 0)->paginate();
            }elseif(request()->param('type') == 'article'){
                $list = Atc::where('is_delete', '<>', 0)->paginate();
            }else{
                return false;
            }
            return $list;
        }else{
            return $this->fetch();
        }
    }

    public function restory(){
        if(empty(request()->param('_id'))) return false;
        $_id = request()->param('_id');
        if(request()->param('type') == 'cate'){
            // $ct = new Ct;
            $result = Ct::where('_id', $_id)->where('is_delete', '<>', 0)->update(['is_delete'=>0]);
        }elseif(request()->param('type') == 'article'){
            // $atc = new Atc;
            $result = Atc::where('_id', $_id)->where('is_delete', '<>', 0)->update(['is_delete'=>0]);
        }else{
            return false;
        }
        if($result){
            return $this->index();
        }else{
            return false;
        }
    }

    public function remove(){
        if(empty(request()->param('_id'))) return false;
        $_id = request()->param('_id');
        if(request()->param('type') == 'cate'){
            $result = Ct::destroy($_id, true);
        }elseif(request()->param('type') == 'article'){
            $result = Atc::destroy($_id, true);
        }else{
            return false;
        }
        if($result){
            return $this->index();
        }else{
            return false;
        }
    }
}