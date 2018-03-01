<?php
namespace app\game\controller;

use think\Controller;
use think\Collection;
use app\model\database\GamePuzzle;

class Puzzle extends Controller{
    public function index(){
        return $this->fetch();
    }
    public function select(){
        $result = GamePuzzle::select();
        $data = collection($result)->shuffle()->slice(0, 10);
        return json($data);
    }
}