<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:66:"/home/calf/admin/shuwen/application/index/view/question/index.html";i:1517730224;s:63:"/home/calf/admin/shuwen/application/index/view/public/base.html";i:1517729886;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>常见问题解答</title>
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
        
    <div class="collection-box" style="background-image: url('/static/media/2/2.jpg');padding-top: 18.74%;">
        <div id="detail" class="book-style-1">
            <div class="book-style-2">
                <div id="list" style="width:100%;padding:1vw 3vw;">
                    <?php if(is_array($question['questions']) || $question['questions'] instanceof \think\Collection || $question['questions'] instanceof \think\Paginator): $i = 0; $__LIST__ = $question['questions'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <a id="<?php echo $vo['target']; ?>"></a>
                    <div style="margin-top:0.65vw">
                        <div style="background:rgb(177,141,100);height:3vw"></div>
                        <div style="background: white;border: 1px solid rgb(177,141,100);margin-top: .2vw;padding: 0 1vw;color: rgb(85,85,85);">
                            <p style="padding: 1.8vw 0;">
                                <span style="color: rgb(170,144,100)">观众提问 ：</span>
                                <?php echo $vo['question']; ?>
                            </p>
                            <hr style="border-top:1px solid rgb(177,141,100);" />
                            <p style="padding: 3vw 0">
                                <span style="color: rgb(170,144,100)">管理员回复 ：</span>
                                <?php echo $vo['answer']; ?>
                            </p>
                        </div>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
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