<?php
/*
 * @Title:
 * @Author: wzs
 * @Date: 2020-04-09 15:15:42
 * @LastEditors: wzs
 * @LastEditTime: 2020-07-30 12:00:43
 * @Description:
 */
namespace app\api\controller\v1;

use app\api\controller\common\Commonapi;

class User extends Commonapi
{

    public function _initialize()
    {

        parent::_initialize();

    }

    public function index()
    {
        if ($this->Re_type == 'pc') {

        } elseif ($this->Re_type == 'wap') {

        } elseif ($this->Re_type == 'weapp') {
            if ($this->user_id) {
                $userInfo = db('weapp_member')->find($this->user_id);
                if ($userInfo) {
                    unset($userInfo['openid']);
                    return show(1, '小程序登录成功', $userInfo, 200);
                } else {
                    return show(401, '登录失效', [], 200);
                }
            }
        }

    }

}
