<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:62:"/home/calf/admin/shuwen/application/index/view/news/index.html";i:1517730285;s:63:"/home/calf/admin/shuwen/application/index/view/public/base.html";i:1517729886;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>新闻资讯</title>
    <link rel="stylesheet" href="__STATIC__/css/index.css">
    <link rel="stylesheet" href="__STATIC__/css/animate.css">
    <script src="__STATIC__/js/jquery.js"></script>
    <script src="__STATIC__/js/react/react.js"></script>
    <script src="__STATIC__/js/react/react-dom.js"></script>
    <script src="__STATIC__/js/react/babel.js"></script>
    <script src="__STATIC__/js/fetch.js"></script>
    <script type="text/babel" src="__STATIC__/js/collection.js"></script>
    
</head>
<body>
    <div class="main">
        
    <div class="collection-box" style="margin-bottom: 8vw;">
        <div style="position:relative;height:100vh;width:80%;margin:0 auto;background: #fff">
            <a id="announcement" style="display: block;height: .5vw"></a>
            <div style="background: url(/static/media/tzgg.jpg) no-repeat center / auto 100%;height: 3.5vw;margin: 3vw 0"></div>
            <div id="announcementList"></div>
        </div>
        <div style="position:relative;height:100vh;width:80%;margin:0 auto;background: #fff">
            <a id="news" style="display: block;height: .5vw"></a>
            <div style="background: url(/static/media/xw.jpg) no-repeat center / auto 100%;height: 3.5vw;margin: 3vw 0"></div>
            <div id="newsList"></div>
        </div>
        <div style="position:relative;height:100vh;width:80%;margin:0 auto;background: #fff">
            <a id="industry" style="display: block;height: .5vw"></a>
            <div style="background: url(/static/media/hydt.jpg) no-repeat center / auto 100%;height: 3.5vw;margin: 3vw 0"></div>
            <div id="industryList"></div>
        </div>
    </div>

        <div class="footer">
            <div class="logo"></div>
            <p>© 2010-2017 箫笛博物馆 版权所有 贵ICP备06052086号</p>
        </div>
    </div>
    <div id="nav"></div>
</body>

<script type="text/babel">
    ReactDOM.render(
        <NewsList category='announcement' />,
        document.getElementById('announcementList')
    );
    ReactDOM.render(
        <NewsList category='news' />,
        document.getElementById('newsList')
    );
    ReactDOM.render(
        <NewsList category='industry' />,
        document.getElementById('industryList')
    );
    ReactDOM.render(
        <Nav />,
        document.getElementById('nav')
    );
</script>

</html>