<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:64:"/home/calf/admin/sichuan/application/app/view/exhibit/the3d.html";i:1512974642;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0, shrink-to-fit=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <title><?php echo $info['title']; ?></title>
    <!-- <script src="https://res.wx.qq.com/mmbizwap/zh_CN/htmledition/js/vconsole/3.0.0/vconsole.min.js"></script> -->
    <script src="__STATIC__/js/3d/es6-promise.min.js"></script>
    <script src="__STATIC__/js/3d/three.min.js"></script>
    <script src="__STATIC__/js/3d/renderers/Projector.js"></script>
    <script src="__STATIC__/js/3d/renderers/CanvasRenderer.js"></script>
    <script src="__STATIC__/js/3d/loaders/draco_decoder.js"></script>
    <script src="__STATIC__/js/3d/loaders/DRACOLoader.js"></script>
    <script src="__STATIC__/js/3d/loaders/MTLLoader.js"></script>
    <script src="__STATIC__/js/3d/controls/VRControls.js"></script>
    <script src="__STATIC__/js/3d/controls/OrbitControls.js"></script>
    <script src="__STATIC__/js/3d/effects/VREffect.js"></script>
    <script src="__STATIC__/js/3d/webvr-polyfill.js"></script>
    <script src="__STATIC__/js/3d/webvr-manager.js"></script>
    <script src="__STATIC__/js/3d/model.js"></script>
    <style>
        body {
            width: 100%;
            height: 100%;
            color: #fff;
            margin: 0px;
            padding: 0;
            overflow: hidden;
        }

        #ThreeJS {
            width: 100vw;
            height: 100vh;
        }
    </style>
</head>
<body>
<div id="ThreeJS"></div>
<script>
    // var vConsole = new VConsole();
    var mdl = new ThreeModel({
        elm: 'ThreeJS', // 熏染画布存放的父节点ID
        path: '<?php echo $info['tdModels'][0]['src']; ?>/', // 模型文件所在路径
        // path: 'http://sichuan.admin.com/uploads/3d/1/', // 模型文件所在路径
        model: 'model.drc', // 模型文件路径，默认 model.drc
        mtl: 'model.mtl',  // mtl 文件路径，默认 model.mtl
        material_name: 'image_material', // 材质与名称（drc压缩会导致obj文件中材质信息丢失），默认 image_material
        light_intensity: 2,  // 光照强度，默认 2
        background: 0x333333, // 场景背景色，默认 0x333333
        scene_transparent: true,  // 是否背景透明，
        auto_rotate: true,  // 是否自行旋转物体
        vr_enabled: false  // 是否开启VR模式
    })
    mdl.start()
</script>
</body>
</html>