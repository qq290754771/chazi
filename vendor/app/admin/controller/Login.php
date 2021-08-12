<?php
/*
 * @Title: 登录类
 * @Descripttion: 登录类
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-05-09 19:58:17
 * @LastEditors: wzs
 * @LastEditTime: 2020-07-29 19:28:27
 */
namespace app\admin\controller;
use think\Controller;
use app\admin\model\User;
class Login extends Controller
{
    public function _initialize(){
        if (session('admin_id') && session(session('gmars_rbac_permission_name'))) {
            $this->redirect('Index/index');
        }
    }
    public function index(){
        if(request()->isPost()) {
            $admin = new User();
            $data = input('post.');
            $num = $admin->login($data);
            if($num == 1){
                return json(['code' => 1, 'msg' => '登录成功!', 'url' => url('/admin/index')]);
            }else {
                return json(array('code' => 0, 'msg' => '用户名或者密码错误，重新输入!'));
            }
        }else{
            return $this->fetch();
        }
    }
    public function check($code){
       return captcha_check($code);
    }
}