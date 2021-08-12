<?php
/*
 * @Title: 
 * @Descripttion: 
 * @version: 
 * @Author: wzs
 * @Date: 2020-06-16 20:22:14
 * @LastEditors: wzs
 * @LastEditTime: 2020-06-16 20:36:36
 */ 
/**
 * Created by WeiYongQiang.
 * User: weiyongqiang <hayixia606@163.com>
 * Date: 2019-04-17
 * Time: 22:52
 */

namespace gmars\model;


use think\Model;

class Base extends Model
{
    protected $connection = '';

    public function __construct($db = '', $data = [])
    {
        parent::__construct($data);
        $this->connection = empty($db)? config('rbac')['db'] : $db;
    }

}