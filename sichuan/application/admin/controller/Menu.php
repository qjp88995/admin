<?php
namespace app\admin\controller;

use app\common\controller\Auth;
use app\admin\model\User as U;

class Menu extends Auth{
    public function index(){
        return json([
            [
                'title'=> '文物管理',
                'icon' => 'home',
                'link' => '/v/venue/exhibit/list',
                'child'=> [],
                'slide'=> [
                    // [
                    //     'title' => '展厅',
                    //     'link'  => '/v/venue/hall',
                    //     'child' => [
                    //         [
                    //             'title' => '展厅列表',
                    //             'link'   => '/v/venue/hall/list'
                    //         ]
                    //     ]
                    // ],
                    [
                        'title' => '文物',
                        'link'  => '/v/venue/exhibit',
                        'child' => [
                            [
                                'title' => '文物列表',
                                'link'  => '/v/venue/exhibit/list'
                            ],
                            [
                                'title' => '添加文物',
                                'link'  => '/v/venue/exhibit/add',
                                'hide'  => true
                            ],
                            [
                                'title' => '修改文物',
                                'link'   => '/v/venue/exhibit/edit',
                                'hide' => true
                            ]
                        ]
                    ],
                    // [
                    //     'title' => '展览',
                    //     'link'  => '/v/venue/exhibition',
                    //     'child' => [
                    //         [
                    //             'title' => '展览列表',
                    //             'link'   => '/v/venue/exhibition/list'
                    //         ]
                    //     ]
                    // ],
                    [
                        'title' => '分类',
                        'link'  => '/v/venue/category/list',
                        'child' => [
                            [
                                'title' => '分类列表',
                                'link'  => '/v/venue/category/list'
                            ],
                            [
                                'title' => '添加分类',
                                'link'  => '/v/venue/category/add',
                                'hide'  => true
                            ],
                            [
                                'title' => '修改分类',
                                'link'  => '/v/venue/category/edit',
                                'hide'  => true
                            ]
                        ]
                    ],
                ]
            ],
            [
                'title'=> '内容管理',
                'icon' => 'file-text',
                'link' => '/v/content/article/list',
                'child'=> [],
                'slide'=> [
                    [
                        'title' => '文章',
                        'link'  => '/v/content/article',
                        'child' => [
                            [
                                'title' => '文章列表',
                                'link'  => '/v/content/article/list'
                            ],
                            [
                                'title' => '添加文章',
                                'link'  => '/v/content/article/add',
                                'hide'  => true
                            ],
                            [
                                'title' => '修改文章',
                                'link'  => '/v/content/article/edit',
                                'hide'  => true
                            ]
                        ]
                    ],
                    [
                        'title' => '分类',
                        'link'  => '/v/content/category',
                        'child' => [
                            [
                                'title' => '分类列表',
                                'link'   => '/v/content/category/list'
                            ],
                            [
                                'title' => '分类列表',
                                'link'  => '/v/content/category/add',
                                'hide'  => true
                            ],
                            [
                                'title' => '分类列表',
                                'link'  => '/v/content/category/edit',
                                'hide'  => true
                            ]
                        ]
                    ]
                ]
            ],
            // [
            //     'title'=> '微课堂管理',
            //     'icon' => 'home',
            //     'link' => '/v/classroom/exam/list',
            //     'child'=> [],
            //     'slide'=> [
            //         [
            //             'title' => '试卷',
            //             'link'  => '/v/classroom/exam',
            //             'child' => [
            //                 [
            //                     'title' => '试卷列表',
            //                     'link'   => '/v/classroom/exam/list'
            //                 ]
            //             ]
            //         ],
            //         [
            //             'title' => '分类',
            //             'link'  => '/v/classroom/category',
            //             'child' => [
            //                 [
            //                     'title' => '分类列表',
            //                     'link'   => '/v/classroom/category/list'
            //                 ]
            //             ]
            //         ],
            //     ]
            // ],
            // [
            //     'title'=> '论坛管理',
            //     'icon' => 'home',
            //     'link' => '/v/forum/board/list',
            //     'child'=> [],
            //     'slide'=> [
            //         [
            //             'title' => '板块',
            //             'link' => '/v/forum/board',
            //             'child' => [
            //                 [
            //                     'title' => '板块列表',
            //                     'link'  => '/v/forum/board/list'
            //                 ]
            //             ]
            //         ],
            //         [
            //             'title' => '帖子',
            //             'link' => '/v/forum/post',
            //             'child' => [
            //                 [
            //                     'title' => '帖子列表',
            //                     'link'  => '/v/forum/post/list'
            //                 ]
            //             ]
            //         ],
            //     ]
            // ],
            // [
            //     'title'=> '微信管理',
            //     'icon' => 'message',
            //     'link' => '',
            //     'child'=> [
            //         [
            //             'title'=> '服务号',
            //             'link' => '/v/wechat/newsList'
            //         ],
            //         [
            //             'title'=> '订阅号',
            //             'link' => '/v/wechat/newsList'
            //         ]
            //     ],
            //     'slide'=> [
            //         [
            //             'title' => '素材资源管理',
            //             'link'   => '/v/',
            //             'child' => [
            //                 [
            //                     'title' => '图文',
            //                     'link'   => '/v/wechat/newsList'
            //                 ]
            //             ]
            //         ],
            //         [
            //             'title' => '粉丝管理',
            //             'link'   => '/v/',
            //             'child' => [
            //                 [
            //                     'title' => '粉丝标签',
            //                     'link'   => '/v/wechat/fansCate'
            //                 ],
            //                 [
            //                     'title' => '已关注粉丝',
            //                     'link'   => '/v/wechat/fans'
            //                 ],
            //                 [
            //                     'title' => '粉丝黑名单',
            //                     'link'   => '/v/wechat/fansBlack'
            //                 ],
            //             ]
            //         ],
            //         [
            //             'title' => '定制管理',
            //             'link'   => '/v/',
            //             'child' => [
            //                 [
            //                     'title' => '关键字',
            //                     'link'   => '/v/'
            //                 ],
            //                 [
            //                     'title' => '关注自动回复',
            //                     'link'   => '/v/'
            //                 ],
            //                 [
            //                     'title' => '无配置默认回复',
            //                     'link'   => '/v/'
            //                 ],
            //                 [
            //                     'title' => '微信菜单定制',
            //                     'link'   => '/v/'
            //                 ]
            //             ]
            //         ],
            //         [
            //             'title' => '账号管理',
            //             'link'   => '/v/',
            //             'child' => [
            //                 [
            //                     'title' => '微信账号',
            //                     'link'   => '/v/'
            //                 ]
            //             ]
            //         ]
            //     ]
            // ],
            // [
            //     'title'=> '系统设置',
            //     'icon' => 'setting',
            //     'link' => '/setting',
            //     'child'=> [],
            //     'slide'=> []
            // ]
        ]);
    }
}