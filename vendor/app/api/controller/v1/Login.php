<?php
/*
 * @Descripttion: 登录注册
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-04-09 19:27:47
 * @LastEditors: wzs
 * @LastEditTime: 2020-07-30 15:16:30
 */
namespace app\api\controller\v1;

use app\api\controller\common\Common;
use app\api\model\User as UserModel;
use app\api\model\WeappUser;
use app\api\validate\User as UserValidate;
use think\Request;

class Login extends Common
{

    public function _initialize()
    {
        parent::_initialize();
    }

    public static function sid()
    {
        if (PHP_SESSION_ACTIVE != session_status()) {
            session_start();
        }
        return session_id();
    }
    // 登录
    public function index()
    {
        if (request()->isPost()) {
            if ($this->Re_type == 'pc') {
            } elseif ($this->Re_type == 'wap') {
                $post = input();
                $validate = new UserValidate();
                if (!$validate->check($post)) {
                    return show(400, $validate->getError(), [], 200);
                } else {
                    $user = UserModel::get(['username' => $post['username']]);
                    if (!$user) {
                        return show(400, '用户不存在！', [], 200);
                    } elseif (!$usercode = UserModel::get(['username' => $post['username'], 'code' => $post['code']])) {
                        return show(400, '密码错误！', [], 200);
                    } else {
                        $data = parent::makeToken($usercode->id);
                        session('user_id', $usercode->id);
                        return show(1, '登录成功', $data, 200);
                    }
                }
            } elseif ($this->Re_type == 'weapp') {
                $post = input();
                $session = $this->miniProgram->sns->getSessionKey($post['code']);
                $sessionKey = $session->session_key;
                try {
                    $res = $this->miniProgram->encryptor->decryptData($sessionKey, $post['iv'], $post['encryptedData']);
                    $openid = $session->openid;
                    $user = WeappUser::get(['openid' => $openid]);
                    if (!$user) {
                        // 用户不存在
                        $usercode = WeappUser::create([
                            'nick_name' => $res['nickName'],
                            'gender' => $res['gender'],
                            'city' => $res['city'],
                            'province' => $res['province'],
                            'country' => $res['country'],
                            'avatarUrl' => $res['avatarUrl'],
                            'openid' => $openid,
                            'createtime' => time(),
                        ]);
                        $data = parent::makeToken($usercode->id);
                        $data['sessionId'] = $this->sid();
                        session('user_id', $usercode->id);
                        return show(1, '登录成功', $data, 200);
                    } else {
                        // 用户已存在
                        $data = parent::makeToken($user->id);
                        $data['sessionId'] = $this->sid();
                        session('user_id', $user->id);
                        return show(1, '登录成功', $data, 200);
                    }

                } catch (\Exception $e) {
                    dump($e);
                }

                // return show(0, '小程序登录成功', [], 200);
            }

        } else {
            return show(401, '非法操作', [], 200);
        }
    }

    public function reg()
    {
        if (request()->isPost()) {
            $post = input();
            $user = UserModel::get(['username' => $post['username']]);
            if ($user) {
                return show(400, '用户已存在！', [], 200);
            } else {
                $usercode = UserModel::create([
                    'name' => $post['name'],
                    'username' => $post['username'],
                    'company' => $post['company'],
                    'department' => $post['department'],
                    'code' => $post['code'],
                ]);
                $data = parent::makeToken($usercode->id);
                session('user_id', $usercode->id);
                return show(1, '登录成功', $data, 200);
            }
        }
    }

    // 刷新token
    public function refreshToken()
    {
        if (request()->isPost()) {
            $post = input();
            // dump($post);
            $tokenArray = $this->decodeToken($post["refresh_token"]);
            if ($tokenArray) {
                // dump($tokenArray);
                // dump($this->Re_type);
                if ($tokenArray['data']->equipment != $this->Re_type && $tokenArray['data']->ip != getIp()) {
                    return show(401, '非法操作', [], 200);
                }
                if ($this->Re_type == 'pc') {
                    $data = parent::makeToken($tokenArray['data']->user_id);
                    session('user_id', $tokenArray['data']->user_id);
                    return show(200, '刷新成功', $data, 200);
                } elseif ($this->Re_type == 'wap') {
                    // 手机端
                    $data = parent::makeToken($tokenArray['data']->user_id);
                    session('user_id', $tokenArray['data']->user_id);
                    return show(200, '刷新成功', $data, 200);
                } elseif ($this->Re_type == 'weapp') {
                    // 小程序
                    $data = parent::makeToken($tokenArray['data']->user_id);
                    $data['sessionId'] = $this->sid();
                    session('user_id', $tokenArray['data']->user_id);
                    return show(200, '刷新成功', $data, 200);
                }
            } else {
                return show(401, '登录超时', [], 200);
            }

        } else {
            return show(401, '非法操作', [], 200);
        }
    }

    // 退出
    public function logout()
    {
        session('user_id', null);
        return show(0, '退出成功', [], 200);
    }

}
