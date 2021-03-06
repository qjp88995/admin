<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
        'path' => '\w+'
    ],
    '[uploads]' => [
        'image/[:path$]' => ['upload/image/index', ['merge_extra_vars'=>true, 'method'=>'get']],
        'audio/[:path$]' => ['upload/index/index', ['merge_extra_vars'=>true, 'method'=>'get']]
    ],
    '__miss__'  => ['index/index/index', ['method' => 'get']]
];
