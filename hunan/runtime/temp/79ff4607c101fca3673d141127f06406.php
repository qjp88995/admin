<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:60:"/home/calf/admin/www/application/index/view/index/index.html";i:1503483527;s:61:"/home/calf/admin/www/application/public/view/index/index.html";i:1504092195;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>layout 后台大布局 - Layui</title>
    <link rel="stylesheet" href="__STATIC__/layui/css/layui.css">
</head>

<body>
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <div class="layui-logo">layui 后台布局</div>
            <!-- 头部区域（可配合layui已有的水平导航） -->
            <ul class="layui-nav layui-layout-left" lay-filter="nav-top">
                <?php if(is_array($topMenu) || $topMenu instanceof \think\Collection || $topMenu instanceof \think\Paginator): $i = 0; $__LIST__ = $topMenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <li class="layui-nav-item<?php echo strtolower($vo['modname']) == strtolower(request()->module())?' layui-this':''; ?>" data-module="<?php echo $vo['modname']; ?>">
                    <a href="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a>
                    <?php if(count($vo['child']) > 0): ?>
                    <dl class="layui-nav-child">
                    <?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ch): $mod = ($i % 2 );++$i;?>
                        <dd><a href="<?php echo $ch['url']; ?>"><?php echo $ch['title']; ?></a></dd>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </dl>
                    <?php endif; ?>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <ul class="layui-nav layui-layout-right">
                <li class="layui-nav-item">
                    <a href="javascript:;">
                      <img src="http://t.cn/RCzsdCq" class="layui-nav-img" />
                      贤心
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;">基本资料</a></dd>
                        <dd><a href="javascript:;">安全设置</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item"><a href="javascript:;">退了</a></li>
            </ul>
        </div>
        <div class="layui-side layui-bg-black">
            <div class="layui-side-scroll">
                <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
                <ul class="layui-nav layui-nav-tree" lay-filter="nav-left" id="leftNav">
                    <?php if(is_array($leftMenu) || $leftMenu instanceof \think\Collection || $leftMenu instanceof \think\Paginator): $i = 0; $__LIST__ = $leftMenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <li class="layui-nav-item <?php echo strtolower($vo['conname'])==strtolower(request()->controller())?'layui-nav-itemed':''; ?>">
                        <a href="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a>
                        <?php if(count($vo['child']) > 0): ?>
                        <dl class="layui-nav-child">
                        <?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ch): $mod = ($i % 2 );++$i;?>
                            <dd class="<?php echo !empty($ch['actname']) && $ch['actname']==request()->action()?'layui-this':''; ?>"><a href="<?php echo $ch['url']; ?>"><?php echo $ch['title']; ?></a></dd>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                        </dl>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>
        <div class="layui-body" style="margin: 15px;">
            
    <div class="layui-row">
        <div class="layui-col-md12">
            <div id="main1" style="height: 400px;"></div>
        </div>
        <div class="layui-col-md12">
            <div id="main2" style="height: 400px;"></div>
        </div>
        <div class="layui-col-md12">
            <div id="main3" style="height: 400px;"></div>
        </div>
        <div class="layui-col-md12">
            <div id="main4" style="height: 400px;"></div>
        </div>
        <div class="layui-col-md12">
            <div id="main5" style="height: 400px;"></div>
        </div>
        <div class="layui-col-md12">
            <div id="main6" style="height: 400px;"></div>
        </div>
    </div>

        </div>
        <div class="layui-footer">
            <!-- 底部固定区域 -->
            © layui.com - 底部固定区域
        </div>
    </div>
    <script src="__STATIC__/layui/layui.js"></script>
    
<script src="__STATIC__/echart/dist/echarts.js"></script>
<script type="text/javascript">
    // 路径配置
    require.config({
        paths: {
            echarts: '__STATIC__/echart/dist'
        }
    });
    // 馆内实施人数
    require(
        [
            'echarts',
            'echarts/chart/bar', // 使用柱状图就加载bar模块，按需加载
            'echarts/chart/line' // 使用折线图就加载line模块，按需加载
        ],
        function (ec) {
            // 基于准备好的dom，初始化echarts图表
            var myChart = ec.init(document.getElementById('main1'));
            var timeTicket;
            var option = {
                title : {
                    text: '当前实时在馆人数'
                },
                tooltip : {
                    trigger: 'axis'
                },
                legend: {
                    data:['热度', '人数']
                },
                toolbox: {
                    show : true,
                    feature : {
                        mark : {show: true},
                        dataView : {show: true, readOnly: false},
                        magicType : {show: true, type: ['line', 'bar']},
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                dataZoom : {
                    show : false,
                    start : 0,
                    end : 100
                },
                xAxis : [
                    {
                        type : 'category',
                        boundaryGap : true,
                        name: '时间',
                        data : (function (){
                            var now = new Date();
                            var res = [];
                            var len = 10;
                            while (len--) {
                                res.unshift(now.getHours()+':'+now.getMinutes());
                                now = new Date(now - 1000*60);
                            }
                            return res;
                        })()
                    },
                    {
                        type : 'category',
                        boundaryGap : true,
                        name: '时间',
                        data : (function (){
                            var now = new Date();
                            var res = [];
                            var len = 10;
                            while (len--) {
                                res.unshift(now.getHours()+':'+now.getMinutes());
                                now = new Date(now - 1000*60);
                            }
                            return res;
                        })()
                    }
                ],
                yAxis : [
                    {
                        type : 'value',
                        scale: true,
                        name : '人数',
                        boundaryGap: [0.2, 0.2]
                    },
                    {
                        type : 'value',
                        scale: true,
                        name : '热度',
                        boundaryGap: [0.2, 0.2]
                    }
                ],
                series : [
                    {
                        name:'人数',
                        type:'line',
                        data:(function (){
                            var res = [];
                            var len = 10;
                            while (len--) {
                                res.push(Math.round(Math.random() * 10 + 1000));
                            }
                            return res;
                        })()
                    },
                    {
                        name:'热度',
                        type:'bar',
                        xAxisIndex: 1,
                        yAxisIndex: 1,
                        data:(function (){
                            var res = [];
                            var len = 10;
                            while (len--) {
                                res.push((Math.random()*10 + 5).toFixed(1) - 0);
                            }
                            return res;
                        })()
                    }
                ]
            };
            var lastData = 11;
            var axisData;
            clearInterval(timeTicket);
            timeTicket = setInterval(function (){
                lastData += Math.random() * ((Math.round(Math.random() * 10) % 2) == 0 ? 1 : -1);
                lastData = lastData.toFixed(1) - 0;
                axisData = (new Date()).getHours()+':'+(new Date()).getMinutes();

                // 动态数据接口 addData
                myChart.addData([
                    [
                        0,        // 系列索引
                        Math.round(Math.random() * 10 + 1000), // 新增数据
                        false,    // 新增数据是否从队列头部插入
                        false,    // 是否增加队列长度，false则自定删除原有数据，队头插入删队尾，队尾插入删队头
                        axisData  // 坐标轴标签
                    ],
                    [
                        1,        // 系列索引
                        lastData, // 新增数据
                        false,     // 新增数据是否从队列头部插入
                        false     // 是否增加队列长度，false则自定删除原有数据，队头插入删队尾，队尾插入删队头
                    ]
                ]);
            }, 1000*60);
            // 为echarts对象加载数据
            myChart.setOption(option);
        }
    );

    // 不同展厅的客流人数分布
    require(
        [
            'echarts',
            'echarts/chart/pie' // 使用饼状图就加载pie模块，按需加载
        ],
        function (ec) {
            // 基于准备好的dom，初始化echarts图表
            var myChart = ec.init(document.getElementById('main2'));

            var option = {
                title : {
                    text: '2017年8月15号展厅人数分布',
                    x:'center',
                    y:'center'
                },
                tooltip : {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    orient : 'vertical',
                    x : 'left',
                    data:['玉器馆','家具馆','陶瓷馆','玺印馆','钱币馆','书法馆','绘画馆','雕塑馆','青铜器馆','少数民族工艺馆','吴门手札精品展（临展）','大英博物馆百物展（临展）','茜茜公主与匈牙利（临展）']
                },
                toolbox: {
                    show : true,
                    feature : {
                        mark : {show: true},
                        dataView : {show: true, readOnly: false},
                        magicType : {
                            show: true,
                            type: ['pie', 'funnel']
                        },
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                calculable : false,
                series : [
                    {
                        name:'展厅',
                        type:'pie',
                        radius : [100, 140],

                        // for funnel
                        x: '60%',
                        width: '35%',
                        funnelAlign: 'left',
                        max: 8000,

                        data:[
                            {value:1378, name:'玉器馆'},
                            {value:327, name:'家具馆'},
                            {value:1573, name:'陶瓷馆'},
                            {value:254, name:'玺印馆'},
                            {value:285, name:'钱币馆'},
                            {value:263, name:'书法馆'},
                            {value:286, name:'绘画馆'},
                            {value:312, name:'雕塑馆'},
                            {value:1862, name:'青铜器馆'},
                            {value:220, name:'少数民族工艺馆'},
                            {value:964, name:'吴门手札精品展（临展）'},
                            {value:8000, name:'大英博物馆百物展（临展）'},
                            {value:1289, name:'茜茜公主与匈牙利（临展）'}
                        ]
                    }
                ]
            };
            var ecConfig = require('echarts/config');
            myChart.on(ecConfig.EVENT.PIE_SELECTED, function (param){
                var selected = param.selected;
                var serie;
                var str = '当前选择： ';
                for (var idx in selected) {
                    serie = option.series[idx];
                    for (var i = 0, l = serie.data.length; i < l; i++) {
                        if (selected[idx][i]) {
                            str += '【系列' + idx + '】' + serie.name + ' : ' +
                                   '【数据' + i + '】' + serie.data[i].name + ' ';
                        }
                    }
                }
                document.getElementById('wrong-message').innerHTML = str;
            });
            // 为echarts对象加载数据
            myChart.setOption(option);
        }
    );
    // 不同时间段馆内客流量
    require(
        [
            'echarts',
            'echarts/chart/bar', // 使用柱状图就加载bar模块，按需加载
            'echarts/chart/line'
        ],
        function (ec) {
            // 基于准备好的dom，初始化echarts图表
            var myChart = ec.init(document.getElementById('main3'));

            var option = {
                title: {
                    text: '2017年8月15日时间段与客流量分析图'
                },
                tooltip : {
                    trigger: 'axis'
                },
                toolbox: {
                    show : true,
                    feature : {
                        mark : {show: true},
                        dataView : {show: true, readOnly: false},
                        magicType: {show: true, type: ['line', 'bar']},
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                calculable : true,
                // legend: {
                //     data:['蒸发量','降水量','平均温度']
                // },
                xAxis : [
                    {
                        type : 'category',
                        name : '时间',
                        data : ['9:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00']
                    }
                ],
                yAxis : [
                    {
                        type : 'value',
                        name : '人数',
                        axisLabel : {
                            formatter: '{value} 人'
                        }
                    }
                ],
                series : [
                    {
                        name:'人数',
                        type:'bar',
                        data:[813, 1217, 1971, 1260, 1997, 2871, 3161, 1723, 1232]
                    }
                ]
            };
            // 为echarts对象加载数据
            myChart.setOption(option);
        }
    );

    //不同地域客流数据
    require(
        [
            'echarts',
            'echarts/chart/map'
        ],
        function (ec) {
            // 基于准备好的dom，初始化echarts图表
            var myChart = ec.init(document.getElementById('main4'));

            var option = {
                title : {
                    text: '2017年8月15号不同地域客流数据',
                    x:'center'
                },
                tooltip : {
                    trigger: 'item'
                },
                legend: {
                    orient: 'vertical',
                    x:'left',
                    data:['春季','夏季','秋季','冬季']
                },
                dataRange: {
                    min: 0,
                    max: 270000*4,
                    x: 'left',
                    y: 'bottom',
                    text:['高','低'],
                    calculable : true
                },
                toolbox: {
                    show: true,
                    orient : 'vertical',
                    x: 'right',
                    y: 'center',
                    feature : {
                        mark : {show: true},
                        dataView : {show: true, readOnly: false},
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                roamController: {
                    show: true,
                    x: 'right',
                    mapTypeControl: {
                        'china': true
                    }
                },
                series : [
                    {
                        name: '春季',
                        type: 'map',
                        mapType: 'china',
                        roam: false,
                        itemStyle:{
                            normal:{label:{show:true}},
                            emphasis:{label:{show:true}}
                        },
                        data:[
                            {name: '北京',value: 10*1000},
                            {name: '天津',value: 3*1000},
                            {name: '上海',value: 270*1000},
                            {name: '重庆',value: 1*1000},
                            {name: '河北',value: 1.2*1000},
                            {name: '河南',value: 1.2*1000},
                            {name: '云南',value: 0.5*1000},
                            {name: '辽宁',value: 0.8*1000},
                            {name: '黑龙江',value: 0.6*1000},
                            {name: '湖南',value: 2*1000},
                            {name: '安徽',value: 20*1000},
                            {name: '山东',value: 3*1000},
                            {name: '新疆',value: 0.3*1000},
                            {name: '江苏',value: 50*1000},
                            {name: '浙江',value: 40*1000},
                            {name: '江西',value: 3*1000},
                            {name: '湖北',value: 5*1000},
                            {name: '广西',value: 1*1000},
                            {name: '甘肃',value: 0.6*1000},
                            {name: '山西',value: 1.6*1000},
                            {name: '内蒙古',value: 0.3*1000},
                            {name: '陕西',value: 1.2*1000},
                            {name: '吉林',value: 1.1*1000},
                            {name: '福建',value: 8*1000},
                            {name: '贵州',value: 0.8*1000},
                            {name: '广东',value: 30*1000},
                            {name: '青海',value: 0.25*1000},
                            {name: '西藏',value: 0.2*1000},
                            {name: '四川',value: 9*1000},
                            {name: '宁夏',value: 0.3*1000},
                            {name: '海南',value: 0.15*1000},
                            {name: '台湾',value: 0.2*1000},
                            {name: '香港',value: 0.15*1000},
                            {name: '澳门',value: 0.1*1000}
                        ]
                    },
                    {
                        name: '夏季',
                        type: 'map',
                        mapType: 'china',
                        roam: false,
                        itemStyle:{
                            normal:{label:{show:true}},
                            emphasis:{label:{show:true}}
                        },
                        data:[
                            {name: '北京',value: 10*1000},
                            {name: '天津',value: 3*1000},
                            {name: '上海',value: 270*1000},
                            {name: '重庆',value: 1*1000},
                            {name: '河北',value: 1.2*1000},
                            {name: '河南',value: 1.2*1000},
                            {name: '云南',value: 0.5*1000},
                            {name: '辽宁',value: 0.8*1000},
                            {name: '黑龙江',value: 0.6*1000},
                            {name: '湖南',value: 2*1000},
                            {name: '安徽',value: 20*1000},
                            {name: '山东',value: 3*1000},
                            {name: '新疆',value: 0.3*1000},
                            {name: '江苏',value: 50*1000},
                            {name: '浙江',value: 40*1000},
                            {name: '江西',value: 3*1000},
                            {name: '湖北',value: 5*1000},
                            {name: '广西',value: 1*1000},
                            {name: '甘肃',value: 0.6*1000},
                            {name: '山西',value: 1.6*1000},
                            {name: '内蒙古',value: 0.3*1000},
                            {name: '陕西',value: 1.2*1000},
                            {name: '吉林',value: 1.1*1000},
                            {name: '福建',value: 8*1000},
                            {name: '贵州',value: 0.8*1000},
                            {name: '广东',value: 30*1000},
                            {name: '青海',value: 0.25*1000},
                            {name: '西藏',value: 0.2*1000},
                            {name: '四川',value: 9*1000},
                            {name: '宁夏',value: 0.3*1000},
                            {name: '海南',value: 0.15*1000},
                            {name: '台湾',value: 0.2*1000},
                            {name: '香港',value: 0.15*1000},
                            {name: '澳门',value: 0.1*1000}
                        ]
                    },
                    {
                        name: '秋季',
                        type: 'map',
                        mapType: 'china',
                        roam: false,
                        itemStyle:{
                            normal:{label:{show:true}},
                            emphasis:{label:{show:true}}
                        },
                        data:[
                            {name: '北京',value: 10*1000},
                            {name: '天津',value: 3*1000},
                            {name: '上海',value: 270*1000},
                            {name: '重庆',value: 1*1000},
                            {name: '河北',value: 1.2*1000},
                            {name: '河南',value: 1.2*1000},
                            {name: '云南',value: 0.5*1000},
                            {name: '辽宁',value: 0.8*1000},
                            {name: '黑龙江',value: 0.6*1000},
                            {name: '湖南',value: 2*1000},
                            {name: '安徽',value: 20*1000},
                            {name: '山东',value: 3*1000},
                            {name: '新疆',value: 0.3*1000},
                            {name: '江苏',value: 50*1000},
                            {name: '浙江',value: 40*1000},
                            {name: '江西',value: 3*1000},
                            {name: '湖北',value: 5*1000},
                            {name: '广西',value: 1*1000},
                            {name: '甘肃',value: 0.6*1000},
                            {name: '山西',value: 1.6*1000},
                            {name: '内蒙古',value: 0.3*1000},
                            {name: '陕西',value: 1.2*1000},
                            {name: '吉林',value: 1.1*1000},
                            {name: '福建',value: 8*1000},
                            {name: '贵州',value: 0.8*1000},
                            {name: '广东',value: 30*1000},
                            {name: '青海',value: 0.25*1000},
                            {name: '西藏',value: 0.2*1000},
                            {name: '四川',value: 9*1000},
                            {name: '宁夏',value: 0.3*1000},
                            {name: '海南',value: 0.15*1000},
                            {name: '台湾',value: 0.2*1000},
                            {name: '香港',value: 0.15*1000},
                            {name: '澳门',value: 0.1*1000}
                        ]
                    },
                    {
                        name: '冬季',
                        type: 'map',
                        mapType: 'china',
                        roam: false,
                        itemStyle:{
                            normal:{label:{show:true}},
                            emphasis:{label:{show:true}}
                        },
                        data:[
                            {name: '北京',value: 10*1000},
                            {name: '天津',value: 3*1000},
                            {name: '上海',value: 270*1000},
                            {name: '重庆',value: 1*1000},
                            {name: '河北',value: 1.2*1000},
                            {name: '河南',value: 1.2*1000},
                            {name: '云南',value: 0.5*1000},
                            {name: '辽宁',value: 0.8*1000},
                            {name: '黑龙江',value: 0.6*1000},
                            {name: '湖南',value: 2*1000},
                            {name: '安徽',value: 20*1000},
                            {name: '山东',value: 3*1000},
                            {name: '新疆',value: 0.3*1000},
                            {name: '江苏',value: 50*1000},
                            {name: '浙江',value: 40*1000},
                            {name: '江西',value: 3*1000},
                            {name: '湖北',value: 5*1000},
                            {name: '广西',value: 1*1000},
                            {name: '甘肃',value: 0.6*1000},
                            {name: '山西',value: 1.6*1000},
                            {name: '内蒙古',value: 0.3*1000},
                            {name: '陕西',value: 1.2*1000},
                            {name: '吉林',value: 1.1*1000},
                            {name: '福建',value: 8*1000},
                            {name: '贵州',value: 0.8*1000},
                            {name: '广东',value: 30*1000},
                            {name: '青海',value: 0.25*1000},
                            {name: '西藏',value: 0.2*1000},
                            {name: '四川',value: 9*1000},
                            {name: '宁夏',value: 0.3*1000},
                            {name: '海南',value: 0.15*1000},
                            {name: '台湾',value: 0.2*1000},
                            {name: '香港',value: 0.15*1000},
                            {name: '澳门',value: 0.1*1000}
                        ]
                    }
                ]
            };
            // 为echarts对象加载数据
            myChart.setOption(option);
        }
    );
    //不同性别的客流量
    require(
        [
            'echarts',
            'echarts/chart/pie', // 使用饼状图就加载pie模块，按需加载
            'echarts/chart/funnel'
        ],
        function (ec) {
            // 基于准备好的dom，初始化echarts图表
            var myChart = ec.init(document.getElementById('main5'));

            var option = {
                title : {
                    text: '2017年8月15号不同性别的客流数据',
                    x:'center'
                },
                tooltip : {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    orient : 'vertical',
                    x : 'left',
                    data:['女','男']
                },
                toolbox: {
                    show : true,
                    feature : {
                        mark : {show: true},
                        dataView : {show: true, readOnly: false},
                        magicType : {
                            show: true,
                            type: ['pie', 'funnel'],
                            option: {
                                funnel: {
                                    x: '25%',
                                    width: '50%',
                                    funnelAlign: 'left',
                                    max: 1548
                                }
                            }
                        },
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                calculable : true,
                series : [
                    {
                        name:'不同性别的客流数据',
                        type:'pie',
                        radius : '55%',
                        center: ['50%', '60%'],
                        data:[
                            {value:4531, name:'女'},
                            {value:3756, name:'男'}
                        ]
                    }
                ]
            };
            // 为echarts对象加载数据
            myChart.setOption(option);
        }
    );
    //不同年龄段的客流数据
    require(
        [
            'echarts',
            'echarts/chart/bar'
        ],
        function (ec) {
            // 基于准备好的dom，初始化echarts图表
            var myChart = ec.init(document.getElementById('main6'));

            var option = {
                title: {
                    x: 'center',
                    text: '2017年8月15号不同年龄段的客流数据'
                    // link: 'http://echarts.baidu.com/doc/example.html'
                },
                tooltip: {
                    trigger: 'item'
                },
                toolbox: {
                    show: true,
                    feature: {
                        dataView: {show: true, readOnly: false},
                        restore: {show: true},
                        saveAsImage: {show: true}
                    }
                },
                calculable: true,
                grid: {
                    borderWidth: 0,
                    y: 80,
                    y2: 60
                },
                xAxis: [
                    {
                        type: 'category',
                        show: false,
                        data: ['18岁以下', '18-25岁', '26-35岁', '36-50岁', '50岁以上']
                    }
                ],
                yAxis: [
                    {
                        type: 'value',
                        show: false
                    }
                ],
                series: [
                    {
                        name: '不同年龄段的客流数据',
                        type: 'bar',
                        itemStyle: {
                            normal: {
                                color: function(params) {
                                    // build a color map as your need.
                                    var colorList = ['#B5C334','#FCCE10','#E87C25','#27727B',
                                       '#FE8463'
                                    ];
                                    return colorList[params.dataIndex]
                                },
                                label: {
                                    show: true,
                                    position: 'top',
                                    formatter: '{b}\n{c}%'
                                }
                            }
                        },
                        data: [5,38,32,15,10],
                        markPoint: {
                            tooltip: {
                                trigger: 'item',
                                backgroundColor: 'rgba(0,0,0,0)',
                                formatter: function(params){
                                    return '<img src="' 
                                            + params.data.symbol.replace('image://', '')
                                            + '"/>';
                                }
                            },
                            data: [
                                {xAxis:0, y: 400, name:'11-20岁', symbolSize:20, symbol: ''},
                                {xAxis:1, y: 400, name:'21-30岁', symbolSize:20, symbol: ''},
                                {xAxis:2, y: 400, name:'31-40岁', symbolSize:20, symbol: ''},
                                {xAxis:3, y: 400, name:'41-50岁', symbolSize:20, symbol: ''},
                                {xAxis:4, y: 400, name:'51-60岁', symbolSize:20, symbol: ''}
                            ]
                        }
                    }
                ]
            };
            // 为echarts对象加载数据
            myChart.setOption(option);
        }
    );
</script>

</body>

</html>