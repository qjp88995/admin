<?php
namespace app\activity\validate;

use think\Validate;

class User extends Validate{
    protected $regex = [
        'idCard' => '(^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$)|(^[1-9]\d{5}\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{2}$)'
    ];
    protected $rule = [
        '_id'          => 'require',
        'name'         => 'require|chsAlpha',
        // 'age'          => 'require|number',
        'sex'          => 'require|in:0,1',
        'idCard'       => 'require|regex:idCard',
        'tel'          => 'require',

        'type'         => 'require|in:0,1',

        'work'         => 'require',

        'school'       => 'require',
        'grade'        => 'require',
        'guardian'     => 'require|array'
    ];
    protected $message = [
        '_id.require'          => '主键不能为空',
        'name.require'         => '姓名不能为空！',
        'name.chsAlpha'        => '姓名只允许汉字和字母！',
        // 'age.require'          => '年龄不能为空！',
        // 'age.number'               => '年龄填写有误！',
        'sex.require'          => '性别不能为空！',
        'sex.in'               => '性别填写有误！',

        'idCard.require'       => '身份证号不能为空！',
        'idCard.regex'         => '身份证号填写有误！',

        'tel.require'          => '联系电话不能为空！',

        'type.require'         => '类别不能为空！',
        'type.in'              => '类别填写有误！',

        'work.require'         => '工作单位不能为空！',

        'school.require'       => '学校不能为空！',
        'grade.require'        => '年级不能为空！',

        'guardian.require'     => '监护人信息不能为空！',
        'guardian.array'       => '监护人信息填写有误！'
    ];
    protected $scene = [
        'add0'   =>  ['name','sex','idCard','tel','type','school','grade','guardian'],
        'add1'   =>  ['name','sex','idCard','tel','type','work'],
        'edit0'  =>  ['_id','name','sex','idCard','tel','type','school','grade','guardian'],
        'edit1'  =>  ['_id','name','sex','idCard','tel','type','work'],
    ];
}