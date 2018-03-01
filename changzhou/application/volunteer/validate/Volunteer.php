<?php
namespace app\volunteer\validate;

use think\Validate;

class Volunteer extends Validate{
    protected $regex = [
        'idCard' => '(^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$)|(^[1-9]\d{5}\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{2}$)'
    ];
    protected $rule = [
        'name'         => 'require|chsAlpha',
        'sex'          => 'require|in:0,1',
        'birthday'     => 'require',
        'education'    => 'require',
        'idCard'       => 'require|regex:idCard',
        'tel'          => 'require',
        'mail'         => 'require|email',
        'photo'        => 'require',

        'type'         => 'require|in:0,1,2',

        'unit'         => 'require',

        'homeAddress'  => 'require',
        'mailAddress'  => 'require',
        'zipCode'      => 'require',
        'contact'      => 'require|array',
        'serviceHours' => 'require|array',
        'skill'        => 'require|array',
        'jobs'         => 'require|array',
        'experience'   => 'require'
    ];
    protected $message = [
        'name.require'         => '姓名不能为空！',
        'name.chsAlpha'        => '姓名只允许汉字和字母！',
        'sex.require'          => '性别不能为空！',
        'sex.in'               => '性别填写有误！',
        'birthday.require'     => '出生日期不能为空！',
        'education.require'    => '学历不能为空！',
        'idCard.require'       => '身份证号不能为空！',
        'idCard.regex'         => '身份证号格式不正确！',
        'tel.require'          => '联系电话不能为空！',

        'mail.require'         => '电子邮箱不能为空！',
        'mail.email'           => '电子邮箱格式不正确！',

        'photo.require'        => '照片不能为空！',

        'type.require'         => '志愿者类别不能为空！',
        'type.in'              => '志愿者类别填写有误！',

        'unit.require'         => '工作单位不能为空！',

        'homeAddress.require'  => '家庭住址不能为空！',
        'mailAddress.require'  => '通讯地址不能为空！',
        'zipCode.require'      => '邮编不能为空！',

        'contact.require'      => '紧急联系人不能为空！',
        'contact.array'        => '紧急联系人格式不正确！',

        'serviceHours.require' => '志愿服务时间不能为空！',
        'serviceHours.array'   => '志愿服务时间格式不正确！',

        'skill.require'        => '个人专业技能不能为空！',
        'skill.array'          => '个人专业技能格式不正确！',

        'jobs.require'         => '志愿服务岗位不能为空！',
        'jobs.array'           => '志愿服务岗位格式不正确！',

        'experience.require'   => '学习及工作经历不能为空！'
    ];
    protected $scene = [
        'edit'  =>  ['sex','birthday','education','tel','mail','photo','type','unit','homeAddress','mailAddress','zipCode','contact','serviceHours','skill','jobs','experience']
    ];
}