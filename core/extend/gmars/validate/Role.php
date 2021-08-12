<?php
/*
 * @Title: 
 * @Descripttion: 
 * @version: 
 * @Author: wzs
 * @Date: 2020-06-16 20:32:53
 * @LastEditors: wzs
 * @LastEditTime: 2020-06-16 21:37:06
 */ 
/**
 * Created by WeiYongQiang.
 * User: weiyongqiang <hayixia606@163.com>
 * Date: 2019-04-17
 * Time: 22:54
 */

namespace gmars\validate;


use think\Validate;

class Role extends Validate
{
    protected $rule = [
        'name' => 'require|max:50|unique:gmars\model\role,name^id'
    ];

    protected $message = [
        'name.require' => '角色名不能为空',
        'name.max' => '角色名不能长于50个字符',
        'name.unique' => '角色名称不能重复'
    ];

}