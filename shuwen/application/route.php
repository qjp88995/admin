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
    '/' => ['index/index/index', ['method'=>'get']],
    '[profile]' => [
        '/' => ['index/profile/index', ['merge_extra_vars'=>true,'method'=>'get']],
        'events' => ['index/profile/events', ['method' => 'post']],
        'events/:id' => ['index/profile/events', ['method' => 'get|post']]
    ],
    '[news]' => [
        '/' => ['index/news/index', ['merge_extra_vars'=>true,'method' => 'get|post']],
        'detail/:id' => ['index/news/detail', ['method' => 'get']]
    ],
    '[collection]' => [
        '/' => ['index/collection/index', ['merge_extra_vars'=>true,'method' => 'get|post']],
        'detail/:id' => ['index/collection/detail', ['method' => 'get']]
    ],
    '[exhibition]' => [
        '/' => ['index/exhibition/index', ['merge_extra_vars'=>true,'method' => 'get|post']],
        'detail/:id' => ['index/exhibition/detail', ['method' => 'get']]
    ],
    '[question]' => [
        '/' => ['index/question/index', ['merge_extra_vars'=>true,'method' => 'get']],
        // 'detail/:id' => ['index/question/detail', ['method' => 'get']]
    ],
    '[education]' => [
        '/' => ['index/education/index', ['merge_extra_vars'=>true,'method' => 'get|post']],
        'detail/:id' => ['index/education/detail', ['method' => 'get']]
    ],
    '[search]' => [
        '/' => ['index/search/index', ['merge_extra_vars'=>true, 'method' => 'get']]
    ],
    '[uploads]' => [
        'image/[:path$]' => ['upload/image/index', ['merge_extra_vars'=>true, 'method'=>'get']],
        'audio/[:path$]' => ['upload/index/index', ['merge_extra_vars'=>true, 'method'=>'get']]
    ],
    '[admin]'  => [
        '/' => ['admin/index/index', ['method' => 'get']]
    ],
    '__miss__'  => ['index/index/index', ['method' => 'get']]
];
