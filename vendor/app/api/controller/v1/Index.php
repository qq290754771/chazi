<?php
/*
 * @Title:
 * @Descripttion:
 * @version:
 * @Author: wzs
 * @Date: 2020-05-26 22:45:09
 * @LastEditors: wzs
 * @LastEditTime: 2020-05-28 10:42:35
 */
namespace app\api\controller\v1;

use app\api\controller\common\Common;



class Index extends Common
{

    public function _initialize()
    {
        parent::_initialize();
    }
    // 生成题

    public function ces(){
        for ($i=1;$i<10;$i++){

        }
        echo $i;
    }
    public function index()
    {
        dump($this->miniProgram);exit;
        return show(1, '提交成功', [], 200);
    }

}
