<?php
return [
    'pathinfo_depr'          => '/',
    'template'               => [
        // 模板引擎类型 支持 php think 支持扩展
        'type'         => 'Think',
        // 模板路径
        'view_path'    => '',
        // 模板后缀
        'view_suffix'  => 'html',
        'taglib_pre_load'=> '\app\common\taglib\Cool',
        // 模板文件名分隔符
        'view_depr'    => '/',
        // 模板引擎普通标签开始标记
        'tpl_begin'    => '{',
        // 模板引擎普通标签结束标记
        'tpl_end'      => '}',
        // 标签库标签开始标记
        'taglib_begin' => '{',
        // 标签库标签结束标记
        'taglib_end'   => '}',

    ],
    'rbac' => [
        'type' => 'service',    //验证方式 jwt(token方式)形式或者service(基于cookie)方式
        'db' => '',        //rbac要使用的数据库配置为空则为默认库(生成表的前缀依赖此配置)
        'salt_token' => 'asdfasfdafasf',    //token加密密钥
        'token_key' => 'Authorization'      //header中用于验证token的名称
    ]
];
