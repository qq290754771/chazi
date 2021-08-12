<?php
/*
 * @Title: 
 * @Author: wzs
 * @Date: 2020-05-28 14:15:05
 * @LastEditors: wzs
 * @LastEditTime: 2020-07-30 10:20:16
 * @Description: 
 */ 

if (!defined('__PUBLIC__')) {
    $_public = rtrim(dirname(rtrim($_SERVER['SCRIPT_NAME'], '/')), '/');
    define('__PUBLIC__', (('/' == $_public || '\\' == $_public) ? '' : $_public).'/public');
}




if (!defined('__ADMIN__')) {
    $_public = rtrim(dirname(rtrim($_SERVER['SCRIPT_NAME'], '/')), '/');
    define('__ADMIN__', (('/' == $_public || '\\' == $_public) ? '' : $_public).'/public/static/admin');
}


// 定义应用目录
define('APP_PATH', __DIR__ . '/app/');
define('RUNTIME_PATH', __DIR__ . '/public/runtime/');
define('LOG_PATH', __DIR__ . '/public/runtime/log/');
define('DATA_PATH', __DIR__ . '/public/runtime/Data/');
//插件目录
define('PLUGIN_PATH', __DIR__ . '/core/plugins/');
define('EXTEND_PATH', __DIR__ . '/core/extend/');
define('ADDONS_PATH', __DIR__ . '/addons/');
define('CONF_PATH', __DIR__.'/config/');
// 加载框架引导文件
require __DIR__ . '/core/thinkphp/start.php';
