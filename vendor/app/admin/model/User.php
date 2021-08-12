<?php
/*
 * @Title: 
 * @Descripttion: 
 * @version: 
 * @Author: wzs
 * @Date: 2020-07-29 19:01:24
 * @LastEditors: wzs
 * @LastEditTime: 2020-07-30 09:42:44
 */ 
namespace app\admin\model;
use gmars\Rbac;
use think\Model;

class User extends Model
{
	public function login($data){
		$user=db('user')->where('user_name',$data['username'])->where('status', 0)->find();
		if($user){
			if($user['password'] == md5($data['password'])){
				$role = db('user_role')->where('user_id',$user['id'])->find();
				db('user')->where('user_name',$data['username'])->update(['last_login_time' => time(),'ip' => getIp()]);
				$log = ['user_id'=>$user['id'], 'log'=> '管理员'.$data['username'].'在'.date('Y:m:d',time()).'登陆,ip:'.getIp(), 'addtime' => time()];
				db('user_log')->insert($log);
				session('username',$user['user_name']);
				session('admin_id',$user['id']);
				session('role_id',$role['role_id']);
				$avatar = $user['avatar']?$user['avatar']:'/static/admin/images/avatar.jpg';
				session('avatar',$avatar);
				$rbac = new Rbac();
				$rbac->cachePermission($user['id']);
				return 1; //信息正确
			}else{
				return -1; //密码错误
			}
		}else{
			return -1; //用户不存在
		}
	}

}
