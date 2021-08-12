<?php
/*
 * @Title:
 * @Author: wzs
 * @Date: 2020-06-16 10:52:38
 * @LastEditors: wzs
 * @LastEditTime: 2020-07-30 10:17:49
 * @Description:
 */
namespace app\socketio\controller;

require_once VENDOR_PATH . "workerman/phpsocket.io/src/autoload.php";
use PHPSocketIO\SocketIO;
use think\Controller;
use Workerman\Worker;

class Server extends Controller
{

    private $io, $context, $isSSL, $appId, $appSecret, $groupConnectionMap, $uidConnectionMap;
    public function _initialize()
    {
        $this->isSSL = false;
        $this->context = array(
            'ssl' => array(
                'local_cert' => '/add/wwwroot/xiche.coolwl.cn/web-msg-sender/1.crt',
                'local_pk' => '/add/wwwroot/xiche.coolwl.cn/web-msg-sender/1.key',
                'verify_peer' => false,
            ),
        );
    }

    public function index()
    {
        if ($this->isSSL) {
            $this->io = new SocketIO(2120, $this->context);
        } else {
            $this->io = new SocketIO(2120);
        }
        $this->io->on('connection', function ($socket) {
            // 验证
            // $this->appId = $appId;
            // $this->appSecret = $appSecret;
            // 登录
            $socket->on('login', function ($uid) use ($socket) {
                if (isset($socket->uid)) {
                    return;
                }
                $uid = (string) $uid;
                if (!isset($this->uidConnectionMap[$uid])) {
                    $this->uidConnectionMap[$uid] = 0;
                }
                $this->uidConnectionMap[$uid] = $this->uidConnectionMap[$uid] + 1;

                $socket->join($uid);
                $socket->uid = $uid;
                $socket->emit('login_ok', "登录成功");

            });
            // 加入房间
            $socket->on('join', function ($uid, $group) use ($socket) {
                if (!isset($this->groupConnectionMap[$group])) {
                    $this->groupConnectionMap[$group] = array();
                }
                if (!in_array($socket->uid, $this->groupConnectionMap[$group])) {
                    array_push($this->groupConnectionMap[$group], $socket->uid);
                }

                $socket->join($group);
                $count = count($this->groupConnectionMap[$group]);
                $str = json_encode($this->groupConnectionMap[$group]);
                $socket->emit('jion_ok', "加入{$group}成功,房间人数{$count},{$str}");
            });

            $socket->on('leave', function ($uid, $group) use ($socket) {
                $socket->leave($group);
                if (count($this->groupConnectionMap[$group]) > 1) {
                    $this->groupConnectionMap[$group] = array_merge(array_diff($this->groupConnectionMap[$group], $socket->uid));
                } else {
                    $this->groupConnectionMap[$group] = array();
                }

                $count = count($this->groupConnectionMap[$group]);
                $socket->emit('leave_ok', "离开{$group}成功,房间人数{$count}");
            });

        });

        $this->io->on('workerStart', function () {
            if ($this->isSSL) {
                $inner_http_worker = new Worker('http://0.0.0.0:2121', $this->context);

            } else {
                $inner_http_worker = new Worker('http://0.0.0.0:2121');
            }
            $inner_http_worker->onMessage = function ($http_connection, $data) {

                switch (input('post.type')) {
                    case 'publish':
                        $to = input('post.to');
                        $group = input('post.group');
                        $from = input('post.from');
                        $content = htmlspecialchars(input('post.content'));
                        $this->io->emit('new_msg', $group);
                        if ($group) {
                            $this->io->to($group)->emit('new_msg', $content, $from);
                        } elseif ($to) {
                            $this->io->to($to)->emit('new_msg', $content, $from);
                        } else {
                            $this->io->emit('new_msg', $content, $from);
                        }
                        if ($to && !isset($this->uidConnectionMap[$to])) {
                            return $http_connection->send('offline');
                        } else {
                            return $http_connection->send('ok');
                        }
                }
                // $http_connection->send('ok');

                // $_POST = $_POST ? $_POST : $_GET;
                // switch (@$_POST['type']) {
                //     case 'publish':
                //         $to = @$_POST['to'];
                //         $group = @$_POST['group'];
                //         $from = @$_POST['from'];
                //         $_POST['content'] = htmlspecialchars(@$_POST['content']);
                //         // 有指定uid则向uid所在socket组发送数据
                //         if ($group) {
                //             $this->io->to($group)->emit('new_msg', $_POST['content'], $from);
                //         } elseif ($to) {
                //             $this->io->to($to)->emit('new_msg', $_POST['content'], $from);
                //             // 否则向所有uid推送数据
                //         } else {
                //             $this->io->emit('new_msg', @$_POST['content'], $from);
                //         }
                //         // http接口返回，如果用户离线socket返回fail
                //         if ($to && !isset($this->uidConnectionMap[$to])) {
                //             return $http_connection->send('offline');
                //         } else {
                //             return $http_connection->send('ok');
                //         }
                // }

                // return $http_connection->send('fail');

            };
            $inner_http_worker->listen();
        });
        Worker::runAll();
    }

}
