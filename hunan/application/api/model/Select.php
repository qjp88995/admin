<?php
namespace app\api\model;
/**
 * Select组件库
 * @var string $from 表单class form:文本和输入框占两行，form-horizontal：文本输入框占一行
 * @var string $type input属性-type
 * @var string $name input属性-name
 * @var array  $options 一些通用选项
 * @return string $html 返回html
 */

use app\api\model\Txmap;

class Select {
    protected $options = [
        'style'        => 'form',
        'title'       => '',
        'type'        => 'text',
        'name'        => '',
        'id'          => '',
        'disabled'    => false,
        'readonly'    => false,
        'placeholder' => '',
        'tips'        => '',
        'div_class'   => '',
        'label_class' => 'col-sm-2',
        'input_class' => 'col-sm-10',
        'hidden'      => [],
        'date'        => [
            'date'    => true,
            'time'    => true,
        ],
        'timeSet' =>[
            'showInputs'  => 'false',     // 是否显示窗口输入框
            'showMeridian'=> 'false',     // true:12小时制 false:24小时制
            'defaultTime' => 'current', // 默认时间
            'showSeconds' => 'true'      // 是否显示秒
        ]

    ];

    protected $type;

    /** @var string label */
    protected $label;

    /** @var string input */
    protected $input;

    /** @var string tips */
    protected $tips = '';

    /** @var string 返回的html */
    protected $html;

}