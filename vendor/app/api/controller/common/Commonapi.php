<?php
/*
 * @Title:
 * @Author: wzs
 * @Date: 2020-05-27 08:39:54
 * @LastEditors: wzs
 * @LastEditTime: 2020-07-30 11:42:46
 * @Description:
 */
namespace app\api\controller\common;

use app\api\controller\common\Common;
use think\Request;

class Commonapi extends Common
{
    protected $pagesize, $user_id;
    //设置北京时间为默认时区
    public function _initialize()
    {
        parent::_initialize();
        $header = request()->header();
        $this->token = $header['authorization'];
        $request = Request::instance();
        $module = $request->module();
        $controller = lcfirst($request->controller());
        $action = $request->action();
        $this->user_id = $this->checkToken($this->token);
    }

}
