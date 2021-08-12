<?php
/*
 * @Title: 
 * @Descripttion: 
 * @version: 
 * @Author: wzs
 * @Date: 2020-05-10 15:22:32
 * @LastEditors: wzs
 * @LastEditTime: 2020-05-10 15:24:01
 */
namespace app\admin\controller\system;
use think\Db;
use think\Request;
use cool\Leftnav;
use app\admin\controller\common\CommonAuth;
use app\admin\model\System as SysModel;
use cool\Sms;
class Build extends CommonAuth
{
    public function index()
    {
        return view('');
    }
}