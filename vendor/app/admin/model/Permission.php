<?php
/*
 * @Title: 
 * @Descripttion: 
 * @version: 
 * @Author: wzs
 * @Date: 2020-05-10 14:23:11
 * @LastEditors: wzs
 * @LastEditTime: 2020-05-10 14:23:28
 */
namespace app\admin\model;
use think\Model;
class Permission extends Model
{
    protected $type       = [
        'addtime' => 'timestamp:Y-m-d H:i:s',
    ];
}