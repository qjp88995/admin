<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:65:"/home/calf/admin/sichuan/application/app/view/article/detail.html";i:1511854899;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $detail['title']; ?></title>
    <!-- <script src="https://res.wx.qq.com/mmbizwap/zh_CN/htmledition/js/vconsole/3.0.0/vconsole.min.js"></script> -->
    <style>
        body{
            font-family: 'SimSong','SimSun';
            letter-spacing: 5px;
        }
        img{
            max-width: 100%;
        }
    </style>
</head>
<body>
    <?php echo $detail['content']; ?>
</body>
<script>
    var vconsole = new VConsole();
</script>
</html>