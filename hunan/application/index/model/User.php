<?php

namespace app\index\model;

use think\Model;
use traits\model\SoftDelete;
class User extends Model{
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $deleteTime = 'is_delete';
    protected function getCreateTimeAttr($value){
        return strtotime($value);
    }
    protected function getCreateUpdateAttr($value, $data){
        return $data['create_time'] . $data['update_time'];
    }
    protected static function base($query){
        $query->where('is_delete',0);
    }
    public function info(){
        return $this->hasOne('Info');
    }
    /**
     * 定义字段类型，在输入和输出的时候自动转换
     * @var array $type initeger - 整型
     * @var array $type float - 浮点型
     * @var array $type boolean - 布尔型
     * @var array $type array - 写入数据库时，数组-json格式字符串，取出时自动解码
     * @var array $type object - 写入时自动编码为json字符串，输出时自动转换为stdclass对象
     * @var array $type serialize - 数据会自动序列化写入，输出时会自动反序列化
     * @var array $type json - 写入时自动json_encode写入，读取时自动json_decode处理
     * @var array $type timestamp - 该字段是时间戳，输入是自动使用strtotime()，输出时会自动转换为dateFormat属性定义的时间字符串格式，例如'birthday' => 'timestamp:Y/m/d'
     * @type datetime - 和timestamp类似，区别在于写入和读取数据的时候都会自动处理成时间字符串Y-m-d H:i:s的格式
     */
    protected $type = [
        'birthday' => 'datetime:Y/m/d',
        'id' => 'integer',
    ];
    /**
     * 数据自动完成
     * @var array $auto 设置写入时完成的字段列表
     * @var array $insert 设置新增时完成的字段列表
     * @var array $update 设置更新时完成的字段列表
     */
    protected $auto = [];
    protected $insert = [];
    protected $update = [];
    /**
     * 数据集对象转数组
     * @param hidden 设置隐藏的属性
     * @param visible 设置输出的属性
     * @param append 追加额外的（获取器）的属性
     * @param appendRelationAttr 追加额外的关联属性
     */

    /**
     * 模型事件
     * @static inti() init静态方法会在实例化模型的时候调用，并且仅会执行一次
            钩子        对应操作    快捷注册方法
        before_insert   新增前     beforeInsert
        after_insert    新增后     afterInsert
        before_update   更新前     beforeUpdate
        after_update    更新后     afterUpdate
        before_write    写入前     beforeWrite
        after_write     写入后     afterWrite
        befoe_delete   删除前     beforeDelete
        after_delete    删除后     afterDelete
     */
    protected static function init(){
        User::beforeInsert(function($user){
            $user->reg_ip = request()->ip();
        });
    }
    /**
     * 注册一个新用户
     * @param array $data 用户注册信息
     * @return int|bool 注册成功返回主键，注册失败-返回false
     */
    public function register($data = []){

    }

    /**
     * 用户登录认证
     * @param string $username 用户名:邮箱或手机号
     * @param string $password 用户密码
     * @return integer 登录成功-用户ID，登录失败-返回0或-1
     */
    public function login($data){
        $result = $this->where('password',md5($data['password']))->where('tel',$data['username'])->find();
        if(!empty($result)){
            $roles = $result['role_ids'];
            $auths = $result['extra_auth'];
            if(!empty($roles)){

            }
            $user['_id']   = $result['_id'];
            $user['tel']   = $result['tel'];
            $user['email'] = $result['email'];
            $user['admin'] = $result['is_admin'];
            $user['info']  = $result['user_info'];
            $user['auths'] = $auths;
            return $user;
        }else{
            return false;
        }
    }
}