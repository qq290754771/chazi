<?php
/*
 * @Title: 公共继承类
 * @Descripttion: 公共继承类
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-05-09 19:58:17
 * @LastEditors: wzs
 * @LastEditTime: 2020-07-31 10:56:10
 */
namespace app\admin\controller\Common;

use gmars\Rbac;
use think\Controller;
use think\Db;

use think\Request;

class Common extends Controller
{
    protected $permission, $menu, $rbac, $method, $biao, $moduleid, $type, $pageName, $controller, $action, $path, $temfile;
    public function _initialize()
    {
        //判断管理员是否登录
        if (!session('admin_id') || !is_array(session(session('gmars_rbac_permission_name')))) {
            $this->redirect('login/index');
        }
        // 设置左侧菜单 并缓存
        $this->menu = cache('menu');
        // dump(cache('menu'));
        if (!$this->menu) {
            $menu = db('permission')->where('status', 1)->where('type', 1)->order('sort asc,id asc,create_time desc,status')->select();
            foreach ($menu as $k => $val) {
                if ($val['state'] == 'page') {
                    $isedit = db($val['module'])->where('p_id', $val['id'])->order('id asc')->value('id');
                    $paths = explode('/', $val['path']);
                    if (empty($isedit)) {
                        $menu[$k]['path'] = $paths[0] . '/add?pid=' . $val['id'];
                    } else {
                        $menu[$k]['path'] = $paths[0] . '/edit?id=' . $isedit . '&pid=' . $val['id'];
                    }
                } else {
                    if ($val['path'] == '#') {
                        $menu[$k]['path'] = '#';
                        // echo 1;
                    } else {
                        $menu[$k]['path'] = $val['path'] . '?pid=' . $val['id'];
                    }
                }
            }
            $this->menu = $menu;
            cache('menu', $this->menu, 0, 'sys');
        }

        // 获取权限列表 并缓存
        $this->permission = cache('permission');
        if (!$this->permission) {
            $this->permission = db('permission')->where('type', 1)->field('id,category_id,description,icon,name,path,pid,sort,status,type')->order('sort asc,id asc,create_time desc')->select();
            cache('permission', $this->permission, 0, 'sys');
        }

        $this->rbac = new Rbac();
        $request = Request::instance();
        $this->module = $request->module();
        $this->controller = lcfirst($request->controller());
        $this->action = $request->action();
        $this->method = $request->method();
        $this->path = $this->controller . '/' . $this->action;
        $menus = subtree($this->menu, 0, session('role_id'));
        $this->assign('action', $this->action);
        $this->assign('controller', $this->controller);
        $this->assign('menus', $menus);
        $this->getPageInfo();

    }

    public function getPageInfo()
    {
        $pageInfo = db('permission')->where('path', $this->path)->find();
        // 页面名称
        $this->pageName = $pageInfo['name'];
        $this->assign('pageName', $this->pageName);
       
        if ($pageInfo['moduleid']) {
            // 页面模型id
            $this->moduleid = $pageInfo['moduleid'];
            // 页面模型对应表名
            $this->biao = db($pageInfo['module']);
        }
        // 页面类型 list?page
        $this->type = $pageInfo['state'];
        $this->assign('active', $pageInfo['id']);
        $this->assign('active_name', $pageInfo['name']);
        $this->assign('active_pid', $pageInfo['pid']);

        if ($pageInfo['pid']) {
            $this->assign('active_pname', db('permission')->where('id', $pageInfo['pid'])->value('name'));
        }

        $temfile = explode('.', $this->controller);
        if (count($temfile) == 2) {
            $this->temfile = $temfile[1];
        } else {
            $this->temfile = $temfile[0];
        }

    }
    //空操作
    public function _empty()
    {

        return $this->error('空操作，返回上次访问页面中...');
    }
}
