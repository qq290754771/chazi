<?php
/*
 * @Title:
 * @Author: wzs
 * @Date: 2020-06-16 10:23:48
 * @LastEditors: wzs
 * @LastEditTime: 2020-06-16 19:41:35
 * @Description:
 */
namespace app\index\controller;

use app\push\event\PushEvent;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        if (!session('user')) {
            $this->redirect('/login');
        }
        return $this->fetch();

    }

    public function login()
    {
        return $this->fetch();
    }

    public function send()
    {
        if (input('msg')) {
            $string = strlen(input('msg')) ? input('msg') : '';
            $group = input('group') ?: '';
            $from = input('from') ?: '';
            $to = input('to') ?: '';
            // dump($from);
            $push = new PushEvent();
            // dump($push);
            if ($group) {
                $push->setFromUser($from)->setGroup($group)->setContent($string)->push();
            } elseif ($to) {
                $push->setFromUser($from)->setUser($to)->setContent($string)->push();
            } else {
                $push->setFromUser($from)->setUser()->setContent($string)->push();
            }
        }

    }
}
