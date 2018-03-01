<?php
namespace app\common\controller;

use app\common\controller\Common;
use app\index\model\Auth as AuthModel;

/**
 * 权限控制类
 * @author 秦嘉鹏
 */
class Auth extends Common{

    /**
     * 初始化函数，同时会执行父类的构造函数
     */
    protected function _initialize(){

    }

    /**
     * 前置方法，在执行每个方法之前都会执行的函数
     * @param function checkAuth 检查权限
     */
    protected $beforeActionList = [
        'checkAuth'
    ];

    protected function checkAuth(){
        if(session('user.admin') === 1){
            return true;
        }else{
            exit(json_encode(
                [
                    'code'=> 403,
                    'msg'  => '请先登录'
                ]
            ));
        }
    }

    protected function renderHtml(){
        if(!request()->isAjax()){
            $topMenu = [
                [
                    'title'   => '大数据',
                    'modname' => 'index',
                    'url'     => url('/'),
                    'child'   => []
                ],
                [
                    'title'   => '文章',
                    'modname' => 'article',
                    'url'     => url('/article/article/index'),
                    'child'   => []
                ],
                [
                    'title'   => '博物馆管理',
                    'modname' => 'venue',
                    'url'     => url('/venue/hall/index'),
                    'child'   => []
                ],
                [
                    'title'   => '在线课堂',
                    'modname' => 'class',
                    'url'     => url('/classroom/index/index'),
                    'child'   => []
                ],
                [
                    'title'   => '管理员',
                    'modname' => 'admin',
                    'url'     => url('/admin/user/index'),
                    'child'   => []
                ],
                [
                    'title'   => '论坛',
                    'modname' => 'forum',
                    'url'     => url('/forum/board/index'),
                    'child'   => []
                ],
                [
                    'title'   => '微信',
                    'modname' => 'wechat',
                    'url'     => 'javascript:;',
                    'child'   => [
                        [
                            'title' => '订阅号',
                            'url'   => '/wechat/index/index'
                        ],
                        [
                            'title' => '服务号',
                            'url'   => '/wechat/index/index'
                        ],
                        [
                            'title' => '企业号',
                            'url'   => '/wechat/index/index'
                        ]
                    ]
                ],
                [
                    'title'   => '文件系统',
                    'modname' => 'multimedia',
                    'url'     => url('/multimedia/index/index'),
                    'child'   => []
                ]
            ];
            $leftMenu = [
                'index' => [
                    [
                        'title'   => '基础支持',
                        'conname' => 'index',
                        'url'     => '/index/index/index',
                        'child'   => []
                    ],
                    [
                        'title'   => '基础支持',
                        'conname' => 'user',
                        'url'     => '/index/user/index',
                        'child'   => []
                    ]
                ],
                'article' => [
                    [
                        'title' => '文章管理',
                        'conname' => 'article',
                        'url'     => 'javascript:;',
                        'child' => [
                            [
                                'title' => '文章列表',
                                'actname' => 'index',
                                'url'     => '/article/article/index'
                            ],
                            [
                                'title' => '添加文章',
                                'actname' => 'add',
                                'url'     => '/article/article/add'
                            ]
                        ]
                    ],
                    [
                        'title' => '分类管理',
                        'conname' => 'cate',
                        'url'     => 'javascript:;',
                        'child' => [
                            [
                                'title' => '分类列表',
                                'actname' => 'index',
                                'url'     => '/article/cate/index'
                            ],
                            [
                                'title' => '添加分类',
                                'actname' => 'add',
                                'url'     => '/article/cate/add'
                            ]
                        ]
                    ]
                ],
                'venue'     => [
                    [
                        'title'   => '基础支持',
                        'conname' => 'jichu',
                        'url'     => '/index/index/index',
                        'child'   => []
                    ],
                    [
                        'title'   => '基础支持',
                        'conname' => 'jichu',
                        'url'     => '/index/index/index',
                        'child'   => []
                    ]
                ],
                'classroom' => [
                    [
                        'title'   => '基础支持',
                        'conname' => 'jichu',
                        'url'     => '/index/index/index',
                        'child'   => []
                    ],
                    [
                        'title'   => '基础支持',
                        'conname' => 'jichu',
                        'url'     => '/index/index/index',
                        'child'   => []
                    ]
                ],
                'admin'     => [
                    [
                        'title'   => '基础支持',
                        'conname' => 'jichu',
                        'url'     => '/index/index/index',
                        'child'   => []
                    ]
                ],
                'forum'     => [
                    [
                        'title'   => '基础支持',
                        'conname' => 'jichu',
                        'url'     => '/index/index/index',
                        'child'   => []
                    ]
                ],
                'wechat'    => [
                    [
                        'title'   => '素材资源管理',
                        'conname' => 'index',
                        'url'     => 'javascript:;',
                        'child'   => [
                            [
                                'title'   => '图文列表',
                                'actname' => 'index',
                                'url'     => '/index/index/list'
                            ],
                            [
                                'title'   => '添加图文',
                                'actname' => 'add',
                                'url'     => '/index/index/add'
                            ]
                        ]
                    ],
                    [
                        'title'   => '微信粉丝管理',
                        'conname' => 'user',
                        'url'     => 'javascript:;',
                        'child'   => [
                            [
                                'title'   => '粉丝标签',
                                'actname' => 'index',
                                'url'     => '/index/index/index'
                            ],
                            [
                                'title'   => '已关注粉丝',
                                'actname' => 'user',
                                'url'     => '/index/index/index'
                            ],
                            [
                                'title'   => '黑名单',
                                'actname' => 'list',
                                'url'     => '/index/index/index'
                            ]
                        ]
                    ],
                    [
                        'title'   => '基础支持',
                        'conname' => 'jichu',
                        'url'     => '/index/index/index',
                        'child'   => []
                    ]
                ],
                'multimedia' => [
                    [
                        'title'   => '文件管理',
                        'conname' => 'index',
                        'url'     => 'javascript:;',
                        'child'   => [
                            [
                                'title'   => '文件库',
                                'actname' => 'index',
                                'url'     => '/multimedia/index/index'
                            ]
                        ]
                    ]
                ]
            ];
            $module = request()->module();
            $this->assign('topMenu', $topMenu);
            $this->assign('leftMenu', $leftMenu[$module]);
        }
    }
}