<?php
namespace app\admin\controller;

use app\common\controller\Common;

class Menu extends Common{
    public function index(){
        return json([
            [
                "title"=> "概况",
                "icon"=> "file-text",
                "link"=> "/admin/profile/intro",
                "child"=> [],
                "slide"=> [
                    [
                        "title"=> "简介",
                        "link"=> "/admin/profile/intro",
                        "child"=> [
                            [
                                "title"=> "简介设置",
                                "link"=> "/admin/profile/intro"
                            ]
                        ]
                    ],
                    [
                        "title"=> "机构",
                        "link"=> "/admin/profile/organization",
                        "child"=> [[
                            "title"=> "机构设置",
                            "link"=> "/admin/profile/organization"
                        ]]
                    ],
                    [
                        "title"=> "开放信息",
                        "link"=> "/admin/profile/information",
                        "child"=> [[
                            "title"=> "开放信息设置",
                            "link"=> "/admin/profile/information"
                        ]]
                    ],
                    [
                        "title"=> "大事记",
                        "link"=> "/admin/profile/events",
                        "child"=> [[
                            "title"=> "大事记设置",
                            "link"=> "/admin/profile/events/list"
                        ]]
                    ],
                    [
                        "title"=> "联系我们",
                        "link"=> "/admin/profile/contact",
                        "child"=> [[
                            "title"=> "联系我们设置",
                            "link"=> "/admin/profile/contact"
                        ]]
                    ],
                    [
                        "title"=> "常见问题解答",
                        "link"=> "/admin/profile/question",
                        "child"=> [[
                            "title"=> "常见问题解答设置",
                            "link"=> "/admin/profile/question"
                        ]]
                    ],
                ]
            ],
            [
                "title"=> "新闻资讯",
                "icon"=> "file-text",
                "link"=> "/admin/news/news/list",
                "child"=> [],
                "slide"=> [
                    [
                        "title"=> "新闻",
                        "link"=> "/admin/news/news",
                        "child"=> [
                            [
                                "title"=> "新闻列表",
                                "link"=> "/admin/news/news/list"
                            ]
                        ]
                    ],
                    [
                        "title"=> "分类",
                        "link"=> "/admin/news/cate",
                        "child"=> [[
                            "title"=> "分类列表",
                            "link"=> "/admin/news/cate/list"
                        ]]
                    ]
                ]
            ],
            [
                "title"=> "展览资讯",
                "icon"=> "file-text",
                "link"=> "/admin/exhibition/exhibition/list",
                "child"=> [],
                "slide"=> [
                    [
                        "title"=> "展览",
                        "link"=> "/admin/exhibition/exhibition",
                        "child"=> [
                            [
                                "title"=> "展览列表",
                                "link"=> "/admin/exhibition/exhibition/list"
                            ]
                        ]
                    ],
                    [
                        "title"=> "分类",
                        "link"=> "/admin/exhibition/cate",
                        "child"=> [[
                            "title"=> "分类列表",
                            "link"=> "/admin/exhibition/cate/list"
                        ]]
                    ]
                ]
            ],
            [
                "title"=> "藏品欣赏",
                "icon"=> "file-text",
                "link"=> "/admin/collection/collection/list",
                "child"=> [],
                "slide"=> [
                    [
                        "title"=> "藏品",
                        "link"=> "/admin/collection/collection",
                        "child"=> [
                            [
                                "title"=> "藏品列表",
                                "link"=> "/admin/collection/collection/list"
                            ]
                        ]
                    ],
                    [
                        "title"=> "分类",
                        "link"=> "/admin/collection/cate",
                        "child"=> [[
                            "title"=> "分类列表",
                            "link"=> "/admin/collection/cate/list"
                        ]]
                    ]
                ]
            ],
            [
                "title"=> "公共教育",
                "icon"=> "file-text",
                "link"=> "/admin/education/education/list",
                "child"=> [],
                "slide"=> [
                    [
                        "title"=> "活动",
                        "link"=> "/admin/education/education",
                        "child"=> [
                            [
                                "title"=> "活动列表",
                                "link"=> "/admin/education/education/list"
                            ]
                        ]
                    ],
                    [
                        "title"=> "分类",
                        "link"=> "/admin/education/cate",
                        "child"=> [[
                            "title"=> "分类列表",
                            "link"=> "/admin/education/cate/list"
                        ]]
                    ]
                ]
            ],
        ]);
    }
}