<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:65:"/home/calf/admin/shuwen/application/index/view/profile/index.html";i:1511511917;s:65:"/home/calf/admin/shuwen/application/index/view/public/header.html";i:1517728647;s:65:"/home/calf/admin/shuwen/application/index/view/public/footer.html";i:1509526494;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>概况</title>
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
    <div class="main" style="background: url('/static/media/2/2.jpg') no-repeat center top / 100% auto;">
        <div class="profile-intro">
            <a id="intro"></a>
            <div class="content">
                <h4><?php echo $intro['title']; ?></h4>
                <div style="text-indent: 2em;">
                <?php echo $intro['content']; ?>
                </div>
            </div>
        </div>
        <div class="profile-organization">
            <a id="organization"></a>
            <div class="title"></div>
            <div class="content">
                <img src="<?php echo $organization->cover; ?>" alt="" style="max-width: 100%;">
            </div>
        </div>
        <div class="profile-information">
            <a id="information"></a>
            <div style="line-height: 2em;">
                <?php echo $information->content; ?>
            </div>
        </div>
        <div class="profile-events">
            <a id="events"></a>
            <div class="title"></div>
            <div id="eventsContent">
                <div class="group">
                    <?php if(is_array($events) || $events instanceof \think\Collection || $events instanceof \think\Paginator): $i = 0; $__LIST__ = $events;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <a href="/profile/events/<?php echo $vo['_id']; ?>"><span><?php echo $vo['year']; ?></span></a>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <button class="left"></button>
                <button class="right"></button>
            </div>
        </div>
        <div class="profile-contact">
            <a id="contact"></a>
            <p style="font-size: 1.8vw;padding: 4vw 0;"><?php echo $contact['title']; ?></p>
            <p style="font-size: 1.2vw;"><?php echo $contact['address']; ?></p>
            <p style="font-size: 1.2vw;padding: 3vw 0;"><?php echo $contact['phone']; ?></p>
        </div>
        <div class="profile-question">
            <a id="question"></a>
            <div class="title"></div>
            <div class="content">
                <?php if(is_array($question['questions']) || $question['questions'] instanceof \think\Collection || $question['questions'] instanceof \think\Paginator): $i = 0; $__LIST__ = $question['questions'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <p title="<?php echo $vo['question']; ?>">
                    <a href="/question#<?php echo $vo['target']; ?>"><?php echo $vo['question']; ?></a>
                </p>
                <?php endforeach; endif; else: echo "" ;endif; ?>
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
        <EventsList />,
        document.getElementById('eventsContent')
    );
    ReactDOM.render(
        <Nav />,
        document.getElementById('nav')
    );
</script>
</html>