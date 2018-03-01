<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

header("Access-Control-Allow-Origin: http://localhost:3000 ");
header("Access-Control-Max-Age: 3628800 ");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: POST,PUT,DELETE');
header('Access-Control-Allow-Credentials: true');
// 定义应用目录
define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', __DIR__);
define('APP_PATH', realpath(__DIR__ . DS . '..' . DS .'application') . DS);
define('ROOT_PATH', dirname(realpath(APP_PATH . DS . '..')) . DS);
define('THINK_PATH', ROOT_PATH . DS . 'thinkphp' . DS);
if(isset($_SERVER['REQUEST_METHOD']) && strtolower($_SERVER['REQUEST_METHOD'])=='options'){
    exit($_SERVER['REQUEST_METHOD']);
}
// 加载框架引导文件
require THINK_PATH . 'start.php';
