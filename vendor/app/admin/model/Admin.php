<?php
/*
 * @Title:
 * @Descripttion:
 * @version:
 * @Author: wzs
 * @Date: 2020-05-09 19:58:17
 * @LastEditors: wzs
 * @LastEditTime: 2020-07-30 09:40:33
 */
namespace app\admin\model;

use gmars\Rbac;
use think\Model;

class Admin extends Model
{
    public function login($data)
    {
        $user = db('user')->where('user_name', $data['username'])->find();
        if ($user) {
            if ($user['password'] == md5($data['password'])) {
                db('user')->where('user_name', $data['username'])->update(['last_login_time' => time(), 'ip' => getIp()]);
                $log = ['user_id' => $user['id'], 'log' => '管理员' . $data['username'] . '在' . date('Y:m:d', time()) . '登陆,ip:' . getIp(), 'addtime' => time()];
                db('user_log')->insert($log);
                session('username', $user['username']);
                session('admin_id', $user['id']);
                $avatar = $user['avatar'] == '' ? '/static/admin/images/avatar.jpg' : $user['avatar'];
                session('avatar', $avatar);
                $rbac = new Rbac();
                $rbac->cachePermission($user['id'], new \DateTime(date('Y-m-d', strtotime("+1 week"))));
                return 1; //信息正确
            } else {
                return -1; //密码错误
            }
        } else {
            return -1; //用户不存在
        }
    }

}
