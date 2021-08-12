<?php
/*
 * @Title: 权限类
 * @Descripttion: 权限类
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-05-19 23:13:16
 * @LastEditors: wzs
 * @LastEditTime: 2020-08-02 13:38:13
 */

namespace app\admin\controller\system;

use app\admin\controller\common\CommonAuth;
use app\admin\model\Permission;
use cool\Leftnav;
use gmars\rbac\Rbac;
use think\Cache;
use think\Db;

class Rule extends CommonAuth
{
    //管理员列表

    public function index()
    {

        if (request()->isPost()) {
            $category_id = 'authRuleList' . input('category_id');
            $nav = new Leftnav();
            $data = cache($category_id);
            if (!$data) {
                $data = $nav->authRule(db('permission')->where('type', 1)->where('category_id', input('category_id'))->field('id,category_id,description,icon,name,path,pid,sort,status,type,is_system')->order('sort asc,id asc,create_time desc')->select());
                cache('$category_id', $data, 0, 'sys');
            }
            foreach ($data as $k => $val) {
                $name = explode('-', $val['name']);
                if (count($name) > 1) {
                    $data[$k]['name'] = $val['description'];
                }
            }
            return json(['data' => $data, 'code' => 1, 'message' => '操作完成']);
        } else {
            $nav = new Leftnav();
            $data = cache('authRuleList');
            if (!$data) {
                $data = $nav->authRule($this->permission);
                cache('authRuleList', $data, 0, 'sys');
            }
            $PermissionCategory = $this->rbac->getPermissionCategory([]);
            // dump( $PermissionCategory );
            // Cache::clear();
            $this->assign('PermissionCategory', $PermissionCategory);
            $this->assign('data', json_encode($data));
            return view();
        }
    }

    public function add()
    {
        if (request()->isPost()) {
            $data = input('post.');
            $data['icon'] = str_replace('layui-icon-', '', $data['icon']);
            if ($data['moduleid']) {
                $data['module'] = db('module')->where('id', $data['moduleid'])->value('name');
            }
            try {
                $permission = $this->rbac->createPermission([
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'status' => $data['status'],
                    'type' => 1,
                    'category_id' => $data['category_id'],
                    'pid' => $data['pid'],
                    'icon' => $data['icon'],
                    'path' => $data['path'],
                    'state' => $data['state'],
                    'module' => $data['module'] ? $data['module'] : '',
                    'moduleid' => $data['moduleid'] ? $data['moduleid'] : null,
                ]);
                $id[0] = $permission->id;
                if ($data['status'] == 1) {
                    $paths = explode('/', $data['path']);
                    $permission = $this->rbac->createPermission([
                        'name' => $data['name'] . '-添加',
                        'description' => '添加',
                        'status' => 0,
                        'type' => 1,
                        'category_id' => $data['category_id'],
                        'pid' => $id[0],
                        'icon' => $data['icon'],
                        'path' => $paths[0] . '/add',
                        'state' => $data['state'],
                        'module' => $data['module'] ? $data['module'] : '',
                        'moduleid' => $data['moduleid'] ? $data['moduleid'] : null,
                    ]);
                    $id[] = $permission->id;
                    $permission = $this->rbac->createPermission([
                        'name' => $data['name'] . '-修改',
                        'description' => '修改',
                        'status' => 0,
                        'type' => 1,
                        'category_id' => $data['category_id'],
                        'pid' => $id[0],
                        'icon' => $data['icon'],
                        'path' => $paths[0] . '/edit',
                        'state' => $data['state'],
                        'module' => $data['module'] ? $data['module'] : '',
                        'moduleid' => $data['moduleid'] ? $data['moduleid'] : null,
                    ]);
                    $id[] = $permission->id;
                    $permission = $this->rbac->createPermission([
                        'name' => $data['name'] . '-删除',
                        'description' => '删除',
                        'status' => 0,
                        'type' => 1,
                        'category_id' => $data['category_id'],
                        'pid' => $id[0],
                        'icon' => $data['icon'],
                        'path' => $paths[0] . '/del',
                        'state' => $data['state'],
                        'module' => $data['module'] ? $data['module'] : '',
                        'moduleid' => $data['moduleid'] ? $data['moduleid'] : null,
                    ]);
                    $id[] = $permission->id;
                    $permission = $this->rbac->createPermission([
                        'name' => $data['name'] . '-排序',
                        'description' => '排序',
                        'status' => 0,
                        'type' => 1,
                        'category_id' => $data['category_id'],
                        'pid' => $id[0],
                        'icon' => $data['icon'],
                        'path' => $paths[0] . '/ruleOrder',
                        'state' => $data['state'],
                        'module' => $data['module'] ? $data['module'] : '',
                        'moduleid' => $data['moduleid'] ? $data['moduleid'] : null,
                    ]);
                    $id[] = $permission->id;
                    $permission = $this->rbac->createPermission([
                        'name' => $data['name'] . '-更改状态',
                        'description' => '更改状态',
                        'status' => 0,
                        'type' => 1,
                        'category_id' => $data['category_id'],
                        'pid' => $id[0],
                        'icon' => $data['icon'],
                        'path' => $paths[0] . '/state',
                        'state' => $data['state'],
                        'module' => $data['module'] ? $data['module'] : '',
                        'moduleid' => $data['moduleid'] ? $data['moduleid'] : null,
                    ]);
                    $id[] = $permission->id;
                }
                if ($id[0]) {
                    $role = db('role')->find(1);
                    $authList = db('role_permission')->where('role_id', 1)->select();
                    $authList = array_column($authList, 'permission_id');
                    sort($authList);
                    if ($id) {
                        $permission_id = implode(',', $id);
                    }
                    $authList = implode(',', $authList) . ',' . $permission_id;

                    $this->rbac->createRole([
                        'id' => $role['id'],
                        'name' => $role['name'],
                        'description' => $role['description'],
                        'status' => 1,
                    ], $authList);
                }

                // Cache::clear('sys');
                return $result = ['code' => 1, 'msg' => '权限添加成功!', 'url' => url('adminRule')];
            } catch (\Exception $e) {
                dump($e);
                return $result = ['code' => 0, 'msg' => '权限添加失败!'];
                die();
                // 终止异常
            }
        } else {
            $nav = new Leftnav();
            $admin_rule = cache('admin_rule');

            if (!$admin_rule) {
                $admin_rule = $nav->menu($this->permission);
                cache('admin_rule', $admin_rule, 0, 'sys');
            }
            // dump($this->permission);
            $admin_category = cache('adminCategory');
            if (!$admin_category) {
                $where['status'] = 1;
                $admin_category = $this->rbac->getPermissionCategory($where);
                cache('adminCategory', $admin_category, 0, 'sys');
            }
            $module = db('module')->where('status', 1)->field('id,title,name')->select();
            $this->assign('modulelist', $module);
            // dump( $arr );
            $this->assign('admin_rule', $admin_rule);
            $this->assign('admin_category', $admin_category);
            return $this->fetch('add');
        }
    }

    public function edit()
    {
        if (request()->isPost()) {
            $data = input('post.');
            try {
                $this->rbac->editPermission([
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'status' => $data['status'],
                    'type' => 1,
                    'category_id' => $data['category_id'],
                    'pid' => $data['pid'],
                    'icon' => $data['icon'],
                    'path' => $data['path'],
                    'state' => $data['state'],
                ]);
                // cache( 'authRule', null );
                // cache( 'authRuleList', null );
                Cache::rm('authRuleList');

                Cache::rm('menu');

                Cache::rm('permission');

                return $result = ['code' => 1, 'msg' => '修改成功!', 'url' => url('adminRule')];
            } catch (\Exception $e) {
                dump($e);
                return $result = ['code' => 0, 'msg' => '修改失败!'];
                // die();
                // 终止异常
            }
        } else {
            $admin_rule = $this->rbac->getPermission(input('id'));
            $this->assign('rule', $admin_rule);

            return $this->fetch('edit');
        }
    }

    public function del()
    {

        try {
            $this->rbac->delPermission(intval(input('param.id')));
            Cache::clear();
            return $result = ['code' => 1, 'msg' => '删除成功!', 'url' => url('adminRule')];
        } catch (\Exception $e) {
            return $result = ['code' => 0, 'msg' => '删除失败!'];
            // die();
            // 终止异常
        }

    }

    public function status()
    {
        $id = input('post.id');
        $statusone = db('permission')->where(array('id' => $id))->value('status');
        //判断当前状态情况
        Cache::clear();
        if (1 == $statusone) {
            $statedata = array('status' => 0);
            db('permission')->where(array('id' => $id))->setField($statedata);
            $result['status'] = 1;
        } else {
            $statedata = array('status' => 1);
            db('permission')->where(array('id' => $id))->setField($statedata);
            $result['status'] = 1;
        }

        return $result;
    }

    public function sort()
    {
        $menu = db('menu');
        $data = input('post.');
        if (false !== Permission::update($data)) {
            Cache::clear();
            return $result = ['code' => 1, 'msg' => '排序更新成功!', 'url' => url('adminRule')];
        } else {
            return $result = ['code' => 0, 'msg' => '排序更新失败!'];
        }
    }

    public function addGroup()
    {
        if (request()->isPost()) {
            $data = input('post.');
            try {
                $this->rbac->savePermissionCategory([
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'sort' => $data['sort'],
                    'create_time' => time(),
                ]);
                Cache::clear();
                return $result = ['code' => 1, 'msg' => '权限组添加成功!', 'url' => url('adminRule')];
            } catch (\Exception $e) {

                return $result = ['code' => 0, 'msg' => '权限组添加失败!'];
                die();
                // 终止异常
            }
        } else {
            //权限列表
            return $this->fetch('addGroup');
        }
    }

    public function delGroup()
    {
        $delPermission = $this->rbac->getPermission('category_id = ' . intval(input('param.id')));
        // dump(array_column($delPermission, 'id'));exit;
        try {
            $delPermission = $this->rbac->getPermission('category_id = ' . intval(input('param.id')));
            if ($this->rbac->delPermission(array_column($delPermission, 'id'))) {
                $this->rbac->delPermissionCategory(intval(input('param.id')));
            }
            return $result = ['code' => 1, 'msg' => '权限组删除成功!'];
        } catch (\Exception $e) {
            return $result = ['code' => 0, 'msg' => '权限组删除失败!'];
            die();
            // 终止异常
        }

        // dump( $data );
    }

    public function children()
    {
        if (request()->isPost()) {
            $data = input('post.');
            $data['icon'] = str_replace('layui-icon-', '', $data['icon']);
            if ($data['moduleid']) {
                $data['module'] = db('module')->where('id', $data['moduleid'])->value('name');
            }
            try {
                $permission = $this->rbac->createPermission([
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'status' => $data['status'],
                    'type' => 1,
                    'category_id' => $data['category_id'],
                    'pid' => $data['pid'],
                    'icon' => $data['icon'],
                    'path' => $data['path'],
                    'state' => $data['state'],
                    'module' => $data['module'] ? $data['module'] : '',
                    'moduleid' => $data['moduleid'] ? $data['moduleid'] : null,
                ]);
                $id[0] = $permission->id;
                if ($data['status'] == 1) {
                    $paths = explode('/', $data['path']);
                    $permission = $this->rbac->createPermission([
                        'name' => $data['name'] . '-添加',
                        'description' => '添加',
                        'status' => 0,
                        'type' => 1,
                        'category_id' => $data['category_id'],
                        'pid' => $id[0],
                        'icon' => $data['icon'],
                        'path' => $paths[0] . '/add',
                        'state' => $data['state'],
                        'module' => $data['module'] ? $data['module'] : '',
                        'moduleid' => $data['moduleid'] ? $data['moduleid'] : null,
                    ]);
                    $id[] = $permission->id;
                    $permission = $this->rbac->createPermission([
                        'name' => $data['name'] . '-修改',
                        'description' => '修改',
                        'status' => 0,
                        'type' => 1,
                        'category_id' => $data['category_id'],
                        'pid' => $id[0],
                        'icon' => $data['icon'],
                        'path' => $paths[0] . '/edit',
                        'state' => $data['state'],
                        'module' => $data['module'] ? $data['module'] : '',
                        'moduleid' => $data['moduleid'] ? $data['moduleid'] : null,
                    ]);
                    $id[] = $permission->id;
                    $permission = $this->rbac->createPermission([
                        'name' => $data['name'] . '-删除',
                        'description' => '删除',
                        'status' => 0,
                        'type' => 1,
                        'category_id' => $data['category_id'],
                        'pid' => $id[0],
                        'icon' => $data['icon'],
                        'path' => $paths[0] . '/del',
                        'state' => $data['state'],
                        'module' => $data['module'] ? $data['module'] : '',
                        'moduleid' => $data['moduleid'] ? $data['moduleid'] : null,
                    ]);
                    $id[] = $permission->id;
                    $permission = $this->rbac->createPermission([
                        'name' => $data['name'] . '-排序',
                        'description' => '排序',
                        'status' => 0,
                        'type' => 1,
                        'category_id' => $data['category_id'],
                        'pid' => $id[0],
                        'icon' => $data['icon'],
                        'path' => $paths[0] . '/ruleOrder',
                        'state' => $data['state'],
                        'module' => $data['module'] ? $data['module'] : '',
                        'moduleid' => $data['moduleid'] ? $data['moduleid'] : null,
                    ]);
                    $id[] = $permission->id;
                    $permission = $this->rbac->createPermission([
                        'name' => $data['name'] . '-更改状态',
                        'description' => '更改状态',
                        'status' => 0,
                        'type' => 1,
                        'category_id' => $data['category_id'],
                        'pid' => $id[0],
                        'icon' => $data['icon'],
                        'path' => $paths[0] . '/state',
                        'state' => $data['state'],
                        'module' => $data['module'] ? $data['module'] : '',
                        'moduleid' => $data['moduleid'] ? $data['moduleid'] : null,
                    ]);
                    $id[] = $permission->id;
                }
                if ($id[0]) {
                    $role = db('role')->find(1);
                    $authList = db('role_permission')->where('role_id', 1)->select();
                    $authList = array_column($authList, 'permission_id');
                    sort($authList);
                    if ($id) {
                        $permission_id = implode(',', $id);
                    }
                    $authList = implode(',', $authList) . ',' . $permission_id;

                    $this->rbac->createRole([
                        'id' => $role['id'],
                        'name' => $role['name'],
                        'description' => $role['description'],
                        'status' => 1,
                    ], $authList);
                }

                // Cache::clear('sys');
                return $result = ['code' => 1, 'msg' => '权限添加成功!', 'url' => url('adminRule')];
            } catch (\Exception $e) {
                dump($e);
                return $result = ['code' => 0, 'msg' => '权限添加失败!'];
                die();
                // 终止异常
            }
        } else {
            $admin_rule = $this->rbac->getPermission(input('id'));
            $this->assign('rule', $admin_rule);
            $nav = new Leftnav();
            $admin_rule = cache('admin_rule');

            if (!$admin_rule) {
                $admin_rule = $nav->menu($this->permission);
                cache('admin_rule', $admin_rule, 0, 'sys');
            }
            // dump($this->permission);
            $admin_category = cache('adminCategory');
            if (!$admin_category) {
                $where['status'] = 1;
                $admin_category = $this->rbac->getPermissionCategory($where);
                cache('adminCategory', $admin_category, 0, 'sys');
            }
            $module = db('module')->where('status', 1)->field('id,title,name')->select();
            $this->assign('modulelist', $module);
            // dump( $arr );
            $this->assign('admin_rule', $admin_rule);
            $this->assign('admin_category', $admin_category);
            return $this->fetch('children');
        }
    }

}
