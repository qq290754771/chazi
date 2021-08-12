<?php
/*
 * @Title: 公共继承类判断权限
 * @Descripttion: 公共继承类判断权限
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-05-09 19:58:17
 * @LastEditors: wzs
 * @LastEditTime: 2020-07-29 19:54:44
 */
namespace app\admin\controller\Common;

use app\admin\controller\common\Common;
use gmars\Rbac;


class CommonAuth extends Common
{
    public $module, $mod, $category;
    public function _initialize()
    {

        parent::_initialize();
        // 获取栏目列表 并缓存
        $this->category = cache('category');
        if (!$this->category) {
            $this->category = db('permission')->alias('p')->where('p.type', 1)->where('p.category_id', 9)->join('cool_category c', 'c.p_id = p.id')->field('p.id,p.category_id,p.description,p.icon,p.name,p.path,p.pid,p.sort,p.status,p.type,p.moduleid,c.ismenu,c.url,c.pagesize')->order('p.sort asc,p.id asc,p.create_time desc')->select();
            cache('category', $this->category, 0, 'sys');
        }

        // 获取模型列表 并缓存
        $this->mod = cache('mod');
        if (!$this->mod) {
            $data = array();
            $list = db('module')->where('status', 1)->order('sort asc,id asc')->select();
            foreach ($list as $key => $value) {
                $data[$value['name']] = $list[$key];
            }
            $this->mod = $data;
            cache('mod', $this->mod, 0, 'sys');
            foreach ($this->mod as $key => $val) {
                $flist = db('field')->where('status', 1)->where('moduleid', $val['id'])->order('sort asc,id asc')->column('*', 'field');
                // dump($flist);
                cache($val['id'] . '_Field', $flist, 0, 'sys');
            }
        }

        $this->rbac = new Rbac();
        // 超级管理员不判断权限
        if (session('role_id') != 1) {
            $this->checkAuth();
        }

        try {
            $this->logs($this->controller . '/' . $this->action, $this->method);
        } catch (\Exception $e) {
            return $this->error('日志写入异常');
            die(); // 终止异常
        }
    }
    // 判断权限操作
    public function checkAuth()
    {
        try {
            if (!$this->rbac->can($this->controller . '/' . $this->action)) {
                return $this->error('您没有权限操作...');
            }
        } catch (\Exception $e) {
            if ($this->method == 'POST') {
                return $this->error('您没有权限操作...');
            } else {
                $this->redirect('login/index');
                die(); // 终止异常
            }

        }

    }
    /**
     * @name: 写入操作日志
     * @descripttion:
     * @param {type} path 访问路径, method 请求方式
     */
    public function logs($path, $method)
    {
        $info = db('permission')->where('path', $path)->find();
        $user = db('user')->where('id', session('admin_id'))->find();
        if ($info['status'] == 1) {
            // 菜单类
            if ($method == 'GET') {
                $data = ['user_id' => $user['id'], 'log' => $user['user_name'] . '在' . date('Y:m:d', time()) . '访问' . $info['name'] . ',请求方式' . $method . ',ip:' . getIp(), 'addtime' => time()];
            } else {
                $data = [];
            }
        } else {
            // 操作类
            $data = ['user_id' => $user['id'], 'log' => $user['user_name'] . '在' . date('Y:m:d', time()) . '访问' . $info['name'] . ',请求方式' . $method . ',ip:' . getIp(), 'addtime' => time()];
        }

        if ($data) {
            try {
                db('user_log')->insertGetId($data);
            } catch (\Exception $e) {
                $this->error('执行错误');
                die(); // 终止异常
            }
        }

    }
    // 空操作
    public function _empty()
    {
        return $this->error('空操作，返回上次访问页面中...');
    }
}
