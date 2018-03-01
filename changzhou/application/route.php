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
    '[upload]' => [
        'image' => ['upload/index/image', ['merge_extra_vars'=>true, 'method'=>'post']],
        'video' => ['upload/index/video', ['merge_extra_vars'=>true, 'method'=>'post']],
        'audio' => ['upload/index/audio', ['merge_extra_vars'=>true, 'method'=>'post']]
    ],
    '[wechat]' => [
        // 获取access_token
        'getAccessToken' => [
            'wechat/Oauth/getAccessToken',
            ['merge_extra_vars'=>true, 'method'=>'get|post']
        ],
        // 获取重定向地址
        'getOauthRedirect' => [
            'wechat/Oauth/getOauthRedirect',
            ['merge_extra_vars'=>true, 'method'=>'get|post']
        ],
        // 通过code获取Access Token
        'getOauthAccessToken' => [
            'wechat/Oauth/getOauthAccessToken',
            ['merge_extra_vars'=>true, 'method'=>'get|post']
        ],
        // 刷新access token并续期
        'getOauthRefreshToken' => [
            'wechat/Oauth/getOauthRefreshToken',
            ['merge_extra_vars'=>true, 'method'=>'get|post']
        ],
        // 获取授权后的用户资料
        'getOauthUserinfo' => [
            'wechat/Oauth/getOauthUserinfo',
            ['merge_extra_vars'=>true, 'method'=>'get|post']
        ],
        // 检验授权凭证是否有效
        'getOauthAuth' => [
            'wechat/Oauth/getOauthAuth',
            ['merge_extra_vars'=>true, 'method'=>'get|post']
        ],
        'login' => [
            'wechat/user/login',
            ['merge_extra_vars'=>true, 'method'=>'get|post']
        ],
        // 小程序通过code获取session_key
        'getSessionKey' => [
            'wechat/Soauth/getSessionKey',
            ['merge_extra_vars'=>true, 'method'=>'get|post']
        ],
    ],
    '__miss__'  => ['index/index/index', ['method' => 'get']]
];
