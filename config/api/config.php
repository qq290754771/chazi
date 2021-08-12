<?php
return [
    'default_return_type'    => 'json',
    'cookie'                 => [
        // cookie 名称前缀
        'prefix'    => '',
        // cookie 保存时间
        'expire'    => 0,
        // cookie 保存路径
        'path'      => '/',
        // cookie 有效域名
        'domain'    => '',
        //  cookie 启用安全传输
        'secure'    => false,
        // httponly设置
        'httponly'  => '',
        // 是否使用 setcookie
        'setcookie' => true,
    ],
    'wx'  => [
        'url' => 'https://api.weixin.qq.com/sns/jscode2session',
        'appid' => 'wxe95df82a6fdea541',
        'secret' => '7fad3e1f04076ff6befe5aa185e5184f',
        'grant_type' => 'yikaobang',
        'mch_id'         => "1503263461",
        'mch_key'        => 'bdxzz2vwrtlyixn2yhqhmyyzf1vi3b3d'
    ],
    'rbac' => [
        'type' => 'jwt',    //验证方式 jwt(token方式)形式或者service(基于cookie)方式
        'db' => '',        //rbac要使用的数据库配置为空则为默认库(生成表的前缀依赖此配置)
        'salt_token' => 'asdfasfdafasf',    //token加密密钥
        'token_key' => 'Authorization'      //header中用于验证token的名称
    ]
];
