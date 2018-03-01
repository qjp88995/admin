<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:63:"/home/calf/admin/shuwen/application/index/view/index/index.html";i:1511953236;s:65:"/home/calf/admin/shuwen/application/index/view/public/header.html";i:1517729161;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>玉屏箫笛博物馆</title>
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
    <div class="index-main">
        <div class="box-1">
            <div class="animated fadeIn">
                <img class="animated bounceInDown" src="__STATIC__/media/1/logo.png" alt="">
                <div>
                    <div class="menu-turn animated bounceInLeft">
                        <a href="/profile">概况</a>
                        <div class="box-2">
                            <a href="/profile#intro">
                                <span>简&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;介</span>
                            </a>
                            <a href="/profile#organization">
                                <span>机 构 设 置</span>
                            </a>
                            <a href="/news#industry">
                                <span>最 新 动 态</span>
                            </a>
                            <a href="/profile#information">
                                <span>开 放 信 息</span>
                            </a>
                            <a href="/profile#events">
                                <span>大 事 记</span>
                            </a>
                            <a href="/profile#contact">
                                <span>联 系 我 们</span>
                            </a>
                            <a href="/question">
                                <span>常 见 问 题 解 答</span>
                            </a>
                        </div>
                    </div>
                    <div class="menu-turn animated bounceInLeft">
                        <a href="/news">新闻资讯</a>
                        <div class="box-2">
                            <a href="/news#announcement">
                                <span>通知公告</span>
                            </a>
                            <a href="/news#news">
                                <span>新&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;闻</span>
                            </a>
                            <a href="/news#industry">
                                <span>行业动态</span>
                            </a>
                        </div>
                    </div>
                    <div class="menu-turn animated bounceInLeft">
                        <a href="/exhibition">展览资讯</a>
                    </div>
                    <div class="menu-turn animated bounceInLeft">
                        <a href="/collection">藏品欣赏</a>
                    </div>
                    <div class="menu-turn animated bounceInLeft">
                        <a href="/education">公共教育</a>
                    </div>
                    <div class="menu-turn animated bounceInLeft">
                        <a href="">玉屏箫笛</a>
                    </div>
                </div>
            </div>
            <div class="animated fadeIn">
                <img class="animated fadeInDownBig" src="__STATIC__/media/index_right_font.png" alt="" style="height:100%;">
            </div>
        </div>

        <div class="clear"></div>

        <div class="box-3">
            <p><?php echo $information['intro']; ?></p>
        </div>

        <div class="box-4">
            <a href=""><img src="__STATIC__/media/1/yupingdixiao.png" alt=""></a>
        </div>

        <div class="box-5">
            <div class="zhuye"></div>
            <div class="title">
                <img src="__STATIC__/media/1/ren.jpg" alt="">
            </div>
            <div class="group">
                <?php if(is_array($notics) || $notics instanceof \think\Collection || $notics instanceof \think\Paginator): $i = 0; $__LIST__ = $notics;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <a href="/news/detail/<?php echo $vo['_id']; ?>">
                    <div class="item">
                        <p time="<?php echo $vo['updateAt']; ?>"><?php echo $vo['title']; ?></p>
                    </div>
                </a>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <div class="clear"></div>
            <div class="more">
                <a href="/news#announcement"><img src="__STATIC__/media/1/more.jpg" alt=""></a>
            </div>
        </div>

        <div class="box-6" style="color: white;line-height: 4vw;padding:4vw;font-size: 1.5vw">
            <p style="width: 50%;text-align:center;">
                <img src="/static/media/didian.png" alt="" style="height:2.4vw;">
                <br/>
                <?php echo $contact['address']; ?>
            </p>
            <p style="width: 50%;text-align:center;">
                <img src="/static/media/dianhua.png" alt="" style="height:1.4vw;">
                <br/>
                <?php echo $contact['phone']; ?>
            </p>
        </div>

        <div class="box-7">
            <div class="logo"></div>
            <p>© 2010-2017 箫笛博物馆 版权所有 贵ICP备06052086号</p>
        </div>
        <div class="search">
            <div>
                <input type="text" id="searchInput">
                <button id="searchButton"></button>
            </div>
        </div>
    </div>
</body>
<script>
    $('.menu-turn').mouseover(function(event) {
        $('.box-2').hide();
        $(this).find('.box-2').show(.5);
    });
    $('.search').click(function(event) {
        event.stopPropagation()
    });
    $('#searchButton').click(function(event) {
        if($('#searchInput').is(':hidden')){
            $('#searchInput').show(500)
        }else{
            var title = $.trim($('#searchInput').val());
            if(title!='') {
                window.open('/search?title='+title);
            }
        }
    });
    $('body').click(function(event) {
        $('#searchInput').hide(500)
    });
</script>
</html>