<?php
/*
 * @Title: 权限组类
 * @Descripttion: 权限组类
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-05-19 23:13:16
 * @LastEditors: wzs
 * @LastEditTime: 2020-07-29 20:22:57
 */

namespace app\admin\controller\system;

use app\admin\controller\common\CommonAuth;
use app\admin\model\Role;
use gmars\Rbac;

class Group extends CommonAuth
{
    //管理员列表

    public function index()
    {

        if (request()->isPost()) {
            $list = Role::all();

            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list, 'rel' => 1];
        }

        return view();
    }

    public function add()
    {
        if (request()->isPost()) {
            $data = input('post.');
            $data['create_time'] = time();
            $rbac = new Rbac();
            try {
                $rbac->createRole([
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'status' => 1,
                ], $data['authList']);

                // PermissionCategory::update( $data );
                $result = ['code' => 1, 'msg' => '用户组添加成功!', 'url' => url('adminGroup')];
            } catch (\Exception $e) {
                $result = ['code' => 0, 'msg' => '用户组添加失败!'];
            }

            return $result;
        } else {
            $this->assign('title', '添加用户组');
            $this->assign('info', 'null');
            $authList = subtreeAuth($this->permission, 0, $id);
            $this->assign('info', json_encode($info, true));
            $this->assign('authList', json_encode($authList, true));

            return $this->fetch('form');
        }
    }

    public function edit()
    {
        if (request()->isPost()) {
            $data = input('post.');
            // dump( $data );
            $rbac = new Rbac();
            try {
                $rbac->createRole([
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'status' => 1,
                ], $data['authList']);
                // PermissionCategory::update( $data );
                $result = ['code' => 1, 'msg' => '用户组修改成功!', 'url' => url('adminGroup')];
            } catch (\Exception $e) {
                $result = ['code' => 0, 'msg' => '用户组修改失败!'];
            }

            return $result;
        } else {
            $id = input('id');
            $info = Role::get(['id' => $id], true);
            // dump( $this->permission );
            $authList = subtreeAuth($this->permission, 0, $id);
            // dump( $authList );
            // exit;
            $this->assign('info', json_encode($info, true));
            $this->assign('authList', json_encode($authList, true));
            $this->assign('title', '编辑用户组');
            return $this->fetch('form');
        }
    }

    public function del()
    {
        try {
            $id = input('id');
            $rbac = new Rbac();
            $rbac->delRole($id);

            return $result = ['code' => 1, 'msg' => '删除成功!'];
        } catch (\Exception $e) {
            return $result = ['code' => 0, 'msg' => '删除失败!'];
        }
    }
}