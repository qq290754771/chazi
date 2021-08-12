<?php
/*
 * @Title: 
 * @Author: wzs
 * @Date: 2020-04-09 15:15:42
 * @LastEditors: wzs
 * @LastEditTime: 2020-04-10 08:38:43
 * @Description: 
 */
namespace app\api\validate;

use think\Validate;

class User extends Validate
{
    protected $table = 'cool_member';
    protected $rule =   [
        'username'  => 'require|min:2',
        'code'   => 'require|min:6'  
    ];
    
    protected $message  =   [
        'user_name.require' => '姓名不能为空！',
        'code.require'   => '员工编号不能为空！',
        'code.min'  => '密码最少为6个字符' 
    ];
    
}