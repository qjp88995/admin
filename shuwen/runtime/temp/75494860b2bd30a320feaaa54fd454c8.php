<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:64:"/home/calf/admin/shuwen/application/index/view/search/index.html";i:1511955714;s:65:"/home/calf/admin/shuwen/application/index/view/public/header.html";i:1510204908;s:65:"/home/calf/admin/shuwen/application/index/view/public/footer.html";i:1509526494;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>搜索结果</title>
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
                <div id="announcementList"></div>
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
        <NewsList title='<?php echo $title; ?>' />,
        document.getElementById('announcementList')
    );
    ReactDOM.render(
        <Nav />,
        document.getElementById('nav')
    );
</script>
</html>