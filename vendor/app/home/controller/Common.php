<?php
namespace app\home\controller;

use think\Input;
use think\Db;
// use cool\Leftnav;
use think\Request;
use think\Controller;

date_default_timezone_set('PRC');
class Common extends Datastatistics
{
    protected $pagesize;
    //设置北京时间为默认时区
    public function _initialize()
    {

        $antepage = '';
        $visitpage = $_SERVER['SERVER_NAME'];
        $this ->visit_detail($visitpage);
        $this ->visit_day($antepage, $visitpage);
    }
    public function _empty()
    {
        return $this->error('空操作，返回上次访问页面中__HOME__.');
    }
}
