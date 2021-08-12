<?php
/*
 * @Title: 管理员类
 * @Descripttion: 管理员类
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-05-19 23:13:16
 * @LastEditors: wzs
 * @LastEditTime: 2020-07-30 09:57:37
 */

namespace app\admin\controller\system;

use app\admin\controller\common\CommonAuth;
use app\admin\model\Role;
use app\admin\model\User;
use gmars\Rbac;
use think\Db;
use think\Validate;

class Admin extends CommonAuth
{
    //管理员列表

    public function index()
    {

        if (request()->isPost()) {
            $val = input('val');
            $url['val'] = $val;
            $this->assign('testval', $val);
            if (session('role_id') == 1 || session('role_id') == 3) {
                if (session('admin_id') != 1) {
                    $where['u.id'] = ['<>', 1];
                }
            } else {
                $where['u.id'] = session('admin_id');
            }
            $list = Db::table(config('database.prefix') . 'user')->alias('u')
                ->join(config('database.prefix') . 'user_role ur', 'ur.user_id = u.id', 'left')
                ->join(config('database.prefix') . 'role r', 'r.id = ur.role_id', 'left')
                ->field('u.*,r.name,ur.role_id')
                ->where($where)
                ->select();

            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list, 'rel' => 1];
        }

        return view();
    }

    public function add()
    {
        if (request()->isPost()) {
            $data = input('post.');

            $check_user = User::get(['user_name' => $data['user_name']]);
            if ($check_user) {
                return $result = ['code' => 0, 'msg' => '用户已存在，请重新输入用户名!'];
            }

            $data['password'] = input('post.password', '', 'md5');
            $data['add_time'] = time();
            $data['ip'] = request()->ip();
            //验证
            $msg = $this->validate($data, 'Admin');
            if ('true' != $msg) {
                return $result = ['code' => 0, 'msg' => $msg];
            }

            //单独验证密码
            $checkPwd = Validate::is(input('post.password'), 'require');
            if (false === $checkPwd) {
                return $result = ['code' => 0, 'msg' => '密码不能为空！'];
            }
            $data['avatar'] = '';
            //添加
            if ($user = User::create($data)) {
                $data1['role_id'] = $data['group_id'];
                $data1['user_id'] = $user->id;
                db('user_role')->insertGetId($data1);
                return ['code' => 1, 'msg' => '管理员添加成功!', 'url' => url('adminList')];
            } else {
                return ['code' => 0, 'msg' => '管理员添加失败!'];
            }
        } else {
            $auth_group = Role::all();
            if (session('role_id') != 1) {
                unset($auth_group[0]);
            }
            $this->assign('authGroup', json_encode($auth_group, true));
            $this->assign('title', lang('add') . lang('admin'));
            $this->assign('info', 'null');
            $this->assign('selected', 'null');

            return view('form');
        }
    }

    public function del()
    {
        $admin_id = input('post.admin_id');
        if (1 == session('role_id')) {
            User::destroy(['id' => $admin_id]);
            $rbac = new Rbac();
            $rbac->delUserRole($admin_id);
            return $result = ['code' => 1, 'msg' => '删除成功!'];
        } else {
            return $result = ['code' => 0, 'msg' => '您没有删除管理员的权限!'];
        }
    }

    public function edit()
    {
        if (request()->isPost()) {
            $data = input('post.');
            $password = input('post.password');

            $map['id'] = array('neq', input('post.id'));
            $where['id'] = input('post.id');
            if (input('post.user_name')) {
                $map['user_name'] = input('post.user_name');
                $check_user = User::get($map);
                if ($check_user) {
                    return $result = ['code' => 0, 'msg' => '用户已存在，请重新输入用户名!'];
                }
            }
            if ($password) {
                $data['password'] = input('post.password', '', 'md5');
            } else {
                unset($data['password']);
            }
            $msg = $this->validate($data, 'Admin');
            if ('true' != $msg) {
                return $result = ['code' => 0, 'msg' => $msg];
            }
            // dump( $data );
            User::update($data);
            db('user_role')->where('user_id', $data['id'])->update(['role_id' => $data['group_id']]);
            return $result = ['code' => 1, 'msg' => '管理员修改成功!', 'url' => url('adminList')];
        } else {
            $auth_group = Role::all();
            $User = User::get(['id' => input('admin_id')]);
            $info['user_name'] = $User->user_name;
            $info['mobile'] = $User->mobile;
            $info['id'] = $User->id;
            $info['avatar'] = $User->avatar;
            $user_role = db('user_role')->where('user_id', $info['id'])->find();
            $selected = db('role')->where('id', $user_role['role_id'])->find();
            $this->assign('selected', json_encode($selected, true));
            $this->assign('info', json_encode($info, true));
            $this->assign('authGroup', json_encode($auth_group, true));
            $this->assign('title', lang('edit') . lang('admin'));
            return view('form');
        }
    }

    public function status()
    {
        $id = input('post.id');
        if (empty($id)) {
            $result['status'] = 0;
            $result['info'] = '用户ID不存在!';
            $result['url'] = url('adminList');
            exit;
        }
        $status = db('user')->where('id=' . $id)->value('status');
        //判断当前状态情况
        if (1 == $status) {
            $data['status'] = 0;
            db('user')->where('id=' . $id)->update($data);
            $result['status'] = 1;
            $result['open'] = 0;
        } else {
            $data['status'] = 1;
            db('user')->where('id=' . $id)->update($data);
            $result['status'] = 1;
            $result['open'] = 1;
        }

        return $result;
    }

    /**
     * 后台操作记录
     */

    public function loglist()
    {
        if (request()->isPost()) {
            if (input('admin_id')) {
                $where['ul.user_id'] = input('admin_id');

            } else {
                if (session('role_id') != 1) {
                    $where['ul.user_id'] = session('admin_id');
                }
            }
            $page = input('page') ? input('page') : 1;
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $list = Db::table(config('database.prefix') . 'user_log')->alias('ul')
                ->join(config('database.prefix') . 'user u', 'ul.user_id = u.id', 'left')
                ->join(config('database.prefix') . 'user_role ur', 'ur.user_id = u.id', 'left')
                ->join(config('database.prefix') . 'role r', 'ur.role_id = r.id', 'left')->field('ul.addtime,ul.log,u.user_name,r.name')
                ->where($where)->order('ul.id desc')->paginate(array(
                'list_rows' => $pageSize,
                'page' => $page,
            ))->toArray();
            $lists = $list['data'];

            foreach ($lists as $key => $value) {
                $lists[$key]['addtime'] = date('Y-m-d H:i:s', $value['addtime']);
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $lists, 'count' => $list['total'], 'rel' => 1];
        } else {
            if (input('admin_id')) {
                return $this->fetch('logList');
            }else{
                return $this->fetch('alllogList');

            }
        }

    }

}
