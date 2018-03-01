<?php
return [
    [
        'name'  => 'index',
        'title' => '大数据',
        'menu'  => [
            [
                'title' => '客流分析',
                'pos'   => 'index@index',
                'url'   => 'index/index/index'
            ],
            [
                'title' => '排行榜',
                'pos'   => 'index@user',
                'url'   => 'index/user/index'
            ]
        ]
    ],
    [
        'name'  => 'article',
        'title' => '内容管理',
        'menu'  => [
            [
                'title' => '文章管理',
                'pos'   => 'article@article',
                'url'   => 'article/article/index'
            ],
            [
                'title' => '文章模板',
                'pos'   => 'article@module',
                'url'   => 'article/module/index'
            ],
            [
                'title' => '回收站',
                'pos'   => 'article@recycle',
                'url'   => 'article/recycle/index'
            ]
        ]
    ],
    [
        'name'  => 'venue',
        'title' => '博物馆管理',
        'menu'  => [
            [
                'title' => '展厅',
                'pos'   => 'venue@hall',
                'url'   => 'venue/hall/index'
            ],
            [
                'title' => '文物',
                'pos'   => 'venue@exhibit',
                'url'   => 'venue/exhibit/index'
            ],
            [
                'title' => '展览',
                'pos'   => 'venue@exhibition',
                'url'   => 'venue/exhibition/index'
            ],
            [
                'title' => '分类',
                'pos'   => 'venue@vcategory',
                'url'   => 'venue/vcategory/index'
            ]
        ]
    ],
    [
        'name'  => 'classroom',
        'title' => '在线课堂',
        'menu'  => [
            [
                'title' => '试题',
                'pos'   => 'classroom@index',
                'url'   => 'classroom/index/index'
            ],
            [
                'title' => '题库',
                'pos'   => 'classroom@question',
                'url'   => 'classroom/question/index'
            ],
            [
                'title' => '分类',
                'pos'   => 'classroom@cate',
                'url'   => 'classroom/cate/index'
            ]
        ]
    ],
    [
        'name'  => 'multimedia',
        'title' => '多媒体管理',
        'menu'  => [
            [
                'title' => '媒体库',
                'pos'   => 'multimedia@index',
                'url'   => 'multimedia/index/index'
            ]
        ]
    ],
    [
        'name'  => 'admin',
        'title' => '管理员',
        'menu'  => [
            [
                'title' => '成员',
                'pos'   => 'admin@user',
                'url'   => 'admin/user/index'
            ],
            [
                'title' => '分组',
                'pos'   => 'admin@group',
                'url'   => 'admin/group/index'
            ],
            [
                'title' => '权限',
                'pos'   => 'admin@authority',
                'url'   => 'admin/authority/index'
            ]
        ]
    ],
    [
        'name'  => 'forum',
        'title' => '论坛管理',
        'menu'  => [
            [
                'title' => '板块',
                'pos'   => 'forum@board',
                'url'   => 'forum/board/index'
            ],
            [
                'title' => '帖子',
                'pos'   => 'forum@post',
                'url'   => 'forum/post/index'
            ]
        ]
    ],
    [
        'name'  => 'wechat',
        'title' => '微信管理',
        'menu'  => [
            [
                'title' => '账号管理',
                'pos'   => 'forum@board',
                'url'   => 'forum/board/index'
            ],
            [
                'title' => '菜单管理',
                'pos'   => 'forum@post',
                'url'   => 'forum/post/index'
            ],
            [
                'title' => '消息管理',
                'pos'   => 'forum@post',
                'url'   => 'forum/post/index'
            ],
            [
                'title' => '用户管理',
                'pos'   => 'forum@post',
                'url'   => 'forum/post/index'
            ]
        ]
    ]
];