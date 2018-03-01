<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:62:"/home/calf/admin/shuwen/application/index/view/index/info.html";i:1509527006;s:64:"/home/calf/admin/shuwen/application/index/view/index/footer.html";i:1509526494;s:61:"/home/calf/admin/shuwen/application/index/view/index/nav.html";i:1509527796;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>树文萧笛博物馆-新闻资讯</title>
    <link rel="stylesheet" href="__STATIC__/css/index.css">
    <script src="__STATIC__/js/jquery.js"></script>
    <script src="__STATIC__/js/index.js"></script>
    <script src="__STATIC__/js/react/react.js"></script>
    <script src="__STATIC__/js/react/react-dom.js"></script>
    <script src="__STATIC__/js/react/babel.js"></script>
</head>
<body>
    <div class="main">
        <div class="info-box">
            <div id="announcement">
                
            </div>
            <div id="new">
                
            </div>
            <div id="intrustry">
                
            </div>
        </div>
                <div class="footer">
            <div class="logo"></div>
            <p>© 2010-2017 箫笛博物馆 版权所有 贵ICP备06052086号</p>
        </div>
    </div>
        <div class="left-nav">
        <button class="show" onclick="$('.left-nav').hide();$('.left-menu').show();"></button>
        <div class="logo"></div>
        <div class="search">
            <div>
                <input type="text" id="searchInput"></input>
                <button onclick="indexSearch()"></button>
            </div>
        </div>
    </div>
    <div class="left-menu">
        <div class="logo"></div>
        <div class="group">
            <div class="item">
                <a href="">首　页</a>
            </div>
            <div class="item">
                <a href="">概　况</a>
                <div class="children">
                    <div class="item">
                        <a href="">简介</a>
                    </div>
                    <div class="item">
                        <a href="">机构设置</a>
                    </div>
                    <div class="item">
                        <a href="">开放信息</a>
                    </div>
                    <div class="item">
                        <a href="">大事记</a>
                    </div>
                    <div class="item">
                        <a href="">联系我们</a>
                    </div>
                    <div class="item">
                        <a href="">常见问题解答</a>
                    </div>
                </div>
            </div>
            <div class="item">
                <a href="">新闻资讯</a>
                <div class="children">
                    <div class="item">
                        <a href="">通知公告</a>
                    </div>
                    <div class="item">
                        <a href="">新闻</a>
                    </div>
                    <div class="item">
                        <a href="">行业动态</a>
                    </div>
                </div>
            </div>
            <div class="item">
                <a href="">展览资讯</a>
                <div class="children">
                    <div class="item">
                        <a href="">当前展览</a>
                    </div>
                    <div class="item">
                        <a href="">历史展览</a>
                    </div>
                    <div class="item">
                        <a href="">展览预告</a>
                    </div>
                </div>
            </div>
            <div class="item">
                <a href="">藏品欣赏</a>
            </div>
            <div class="item">
                <a href="">公共教育</a>
                <div class="children">
                    <div class="item">
                        <a href="">活动资讯</a>
                    </div>
                </div>
            </div>
            <div class="item">
                <a href="">玉屏笛箫</a>
            </div>
        </div>
        <button class="hide" onclick="$('.left-nav').show();$('.left-menu').hide();"></button>
    </div>
</body>
<script type="text/babel" src="__STATIC__/js/info.js"></script>
</html>