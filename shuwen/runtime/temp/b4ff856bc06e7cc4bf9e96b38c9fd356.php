<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:69:"/home/calf/admin/shuwen/application/index/view/collection/detail.html";i:1511511774;s:65:"/home/calf/admin/shuwen/application/index/view/public/header.html";i:1510204908;s:65:"/home/calf/admin/shuwen/application/index/view/public/footer.html";i:1509526494;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>某某笛子</title>
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
        <div class="collection-box">
            <div id="detail" class="book-style-1">
                <div class="book-style-2">
                    <!-- <div id="banner"></div> -->
                    <div style="width: 85%;margin:0 auto 5vw;text-align: center">
                        <div class="cover" style="overflow: hidden;">
                            <img src="<?php echo !empty($detail['cover'])?$detail['cover']:''; ?>" alt="<?php echo $detail['title']; ?>" style="max-width: 100%;">
                        </div>
                        <h1 style="margin: 1vw 0;font-size: 2vw;font-weight: 500;">
                            <?php echo $detail['title']; ?>
                        </h1>
                        <div style="text-align: left;font-size: 1.1vw;color:rgb(85,85,85);text-indent: 2em;">
                            <?php echo !empty($detail['content'])?$detail['content']:''; ?>
                        </div>
                    </div>
                </div>
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
        <Nav />,
        document.getElementById('nav')
    );
</script>
</html>