<?php
namespace app\api\controller\common;

use EasyWeChat\Foundation\Application;
use think\Controller;
use think\Request;
use \Firebase\JWT\JWT;

// https://www.bookstack.cn/read/EasyWechat-v3.x/installation.md

class Common extends Controller
{

    public $miniProgram;
    public function _initialize()
    {
        $header = request()->header();
        $original = $header['origin'];
        header('Access-Control-Allow-Origin: ' . $original);
        header('Access-Control-Allow-Headers: Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With, type');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE');
        header('Access-Control-Max-Age: 1728000');
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'OPTIONS') {
            exit;
        }
        $request = Request::instance();
        parent::_initialize();
        $this->Re_type = $header['type'];
        $weappConfig = db('weapp')->field('app_id,secret')->find(1);
        $miniConfig = array('mini_program' => $weappConfig);
        $miniConfig = $miniConfig ? $miniConfig : config('weapp');
        $app = new Application($miniConfig);
        $this->miniProgram = $app->mini_program;
    }
    /**
     * 生成Token
     * @param int $length
     * @param array $data
     * @return string
     */
    public function makeToken($user_id, $exp = 43200)
    {
        $key = "qixing";
        $time = time();
        $data = [
            'iat' => $time, //签发时间
            'data' => [
                'user_id' => $user_id,
                'ip' => getIp(),
                'equipment' => $this->Re_type,
            ],
        ];
        $access_token = $data;
        $access_token['scopes'] = 'role_access';
        $access_token['exp'] = $time + $exp;

        $refresh_token = $data;
        $refresh_token['scopes'] = 'role_refresh';
        $refresh_token['exp'] = $time + ($exp * 200);
        // dump($access_token);
        $jsonList = [
            'access_token' => JWT::encode($access_token, $key),
            'refresh_token' => JWT::encode($refresh_token, $key),
            'token_type' => 'wzs',
        ];
        return $jsonList;
    }

    /**
     * 解码Token
     * @param int $length
     * @param string $token string
     * @return array
     */
    public function decodeToken($token)
    {
        $key = "qixing";
        JWT::$leeway = 1;
        try {
            $decoded = JWT::decode($token, $key, array('HS256'));
            $arr = (array) $decoded;
            return $arr;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 验证Token
     * @param int $length
     * @param string $token string
     * @return array
     */
    public function checkToken($token)
    {
        if ($token) {
            $tokenArray = $this->decodeToken($token);
            if ($tokenArray) {
                // 如果能解开token 说明没过期
                if ($this->Re_type == 'pc') {
                    if ($tokenArray['data']->equipment != $this->Re_type && $tokenArray['data']->ip != getIp() && $tokenArray['data']->user_id != session('user_id')) {
                        return show(400, '非法操作', [], 200);
                    }
                    return $tokenArray['data']->user_id;
                } elseif ($this->Re_type == 'wap') {
                    if ($tokenArray['data']->equipment != $this->Re_type && $tokenArray['data']->ip != getIp() && $tokenArray['data']->user_id != session('user_id')) {
                        return show(401, '非法操作', [], 200);
                    } else {
                        return $tokenArray['data']->user_id;
                    }
                } else {
                    return $tokenArray['data']->user_id;
                }
            } else {
                return show(402, '授权过期', [], 200);
            }
        } else {
            return show(401, '登录失效', [], 200);
        }
    }

    /**
     * 生成随机码
     * @param int $length
     * @param string $type string|mix|number|special
     * @return string
     */
    private function randCode($length = 6, $type = 'mix')
    {
        $number = '0123456789';
        $seed = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $specialChar = '!@#$%^&*()_+[]|';
        $randRes = "";
        switch ($type) {
            case 'string':
                for ($i = 0; $i < $length; $i++) {
                    $randomInt = rand(0, strlen($seed) - 1);
                    $randRes .= $seed{$randomInt};
                }
                break;
            case 'number':
                for ($i = 0; $i < $length; $i++) {
                    $randomInt = rand(0, strlen($number) - 1);
                    $randRes .= $number{$randomInt};
                }
                break;
            case 'mix':
                $mix = $number . $seed;
                for ($i = 0; $i < $length; $i++) {
                    $randomInt = rand(0, strlen($mix) - 1);
                    $randRes .= $mix{$randomInt};
                }
                break;
            case 'special':
                $special = $number . $seed . $specialChar;
                for ($i = 0; $i < $length; $i++) {
                    $randomInt = rand(0, strlen($special) - 1);
                    $randRes .= $special{$randomInt};
                }
                break;
        }
        return $randRes;
    }

    public function _empty()
    {
        return show(0, '空操作。。。', [], 400);
    }
}
