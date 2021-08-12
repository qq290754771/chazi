<?php
/*
 * @Title: io推送服务
 * @Author: wzs
 * @Date: 2020-06-16 10:49:39
 * @LastEditors: wzs
 * @LastEditTime: 2020-07-30 10:21:22
 * @Description: io推送服务 linux 执行命令启动 win 执行start_for_win.bat启动
 * 全局启动 php socketio.php start -d
 * 启动 php socketio.php start
 * 停止 php socketio.php stop
 * 重启 php socketio.php restart 
 * 状态 php socketio.php status 
 */ 
define('APP_PATH', __DIR__ . '/app/');
define('RUNTIME_PATH', __DIR__ . '/public/runtime/');
define('LOG_PATH', __DIR__ . '/public/runtime/log/');
define('DATA_PATH', __DIR__ . '/public/runtime/Data/');

define('BIND_MODULE', 'socketio/Server/index');
// 加载框架引导文件
require __DIR__ . '/core/thinkphp/start.php';
